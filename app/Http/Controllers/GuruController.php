<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Guru;
use App\Models\User;

class GuruController extends Controller
{

    private string $title = 'Data Guru';


    public function index()
    {
        return view('guru.index', [
            'title' => $this->title,
            'data_guru' => Guru::orderBy('nama', 'asc')->filter(request(['search']))->paginate(6)->withQueryString()
        ]);
    }

    public function show(Guru $guru)
    {
        return view(
            'guru.detail',
            [
                'title' => $this->title,
                'data_guru_single' => $guru
            ]
        );
    }

    public function create()
    {
        return view('guru.create', [
            'title' => $this->title,
        ]);
    }

    public function checkUsername(Request $request)
    {
        $exists = User::where('username', $request->username)->exists();
        return response()->json(['available' => !$exists]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'username' => ['required', 'unique:users,username', 'regex:/^\S*$/', 'min:3'],
            'password' => 'required',
            'nip' => 'nullable|string',
            'nuptk' => 'nullable|string',
            'gender' => 'required|in:L,P',
        ]);

        // Store in users table
        $user = new User();
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->password = bcrypt($validated['password']);
        $user->gender = $validated['gender'];
        $user->role = 'guru';
        $user->save();

        // Store in gurus table
        $guru = new Guru();
        $guru->user_id = $user->id;
        $guru->nama = $validated['nama'];
        $guru->nip = $validated['nip'] ?? null;
        $guru->nuptk = $validated['nuptk'] ?? null;
        $guru->save();

        return redirect('/guru')->with('success-tambah', 'Data guru berhasil ditambahkan.');
    }

    public function destroy(Guru $guru)
    {
        Guru::destroy($guru->id);
        User::destroy($guru->user_id);
        return redirect('/guru')->with('success-hapus', 'Data guru berhasil dihapus.');
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', [
            'title' => $this->title,
            'guru' => $guru
        ]);
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($guru->user_id),
            ],

            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($guru->user_id),
                'regex:/^\S*$/', 
                'min:3',
            ],

            'gender' => 'required|in:L,P',

            'password' => 'nullable',

            'nip' => [
                'nullable',
                'string',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'nuptk' => [
                'nullable',
                'string',
                Rule::unique('gurus', 'nuptk')->ignore($guru->id),
            ],
        ]);

        // Update the User record
        $user = User::find($guru->user_id);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->gender = $request->gender;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); 
        }
        $user->save();

        // Update the Guru record
        $guru = Guru::find($guru->id);
        $guru->nama = $request->nama;
        $guru->nip = $request->nip;
        $guru->nuptk = $request->nuptk;
        $guru->save();

        return redirect()->route('guru.index')->with('success-edit', 'Guru data updated successfully!');
    }
}
