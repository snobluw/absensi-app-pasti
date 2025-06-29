<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->role === 'admin' ? $user->admin : $user->guru;

        return view('profile.index', [
            'title' => 'Profile',
            'profile' => $profile
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // === Avatar update ===
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:1048',
            ]);

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('profile-images', 'public');
            $user->avatar = $path;
            $user->save();

            return back()->with('success-avatar', 'Avatar berhasil diperbarui!');
        }

        // === Profile info update (name + email) ===
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $user->email = $request->email;
        if ($user->role === 'admin') {
            $user->admin->nama = $request->name;
            $user->admin->save();
        } else {
            $user->guru->nama = $request->name;
            $user->guru->save();
        }

        $user->save();

        return back()->with('success-avatar', 'Profil berhasil diperbarui.');
    }

    public function updateSettings(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('success-avatar', 'Pengaturan akun berhasil diperbarui.');
    }
}
