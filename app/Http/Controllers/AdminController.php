<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'title' => 'Data Admin',
            'data_admin' => Admin::orderBy('nama', 'asc')->filter(request(['search']))->paginate(6)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', [
            'title' => 'Tambah Admin',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'username' => ['required', 'unique:users,username', 'regex:/^\S*$/', 'min:3'],
            'password' => 'required',
            'nip' => 'nullable|string',
            'gender' => 'required|in:L,P',
        ]);

        // Store in users table
        $user = new User();
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->password = bcrypt($validated['password']);
        $user->gender = $validated['gender'];
        $user->role = 'admin';
        $user->save();

        // Store in admins table
        $admin = new Admin();
        $admin->user_id = $user->id;
        $admin->nama = $validated['nama'];
        $admin->nip = $validated['nip'] ?? null;
        $admin->save();

        return redirect('/admin')->with('success-tambah', 'Data admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view(
            'admin.detail',
            [
                'name' => 'John Does',
                'role' => 'admin',
                'title' => 'Detail Admin',
                'data_admin_single' => $admin
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admin.edit', [
            'title' => 'Edit Admin',
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $request->validate([
            'nama' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($admin->user_id),
            ],

            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($admin->user_id),
                'regex:/^\S*$/', 
                'min:3',
            ],

            'gender' => 'required|in:L,P',

            'password' => 'nullable',

            'nip' => [
                'nullable',
                'string',
                Rule::unique('admins', 'nip')->ignore($admin->id),
            ],
        ]);

        // Update the User record
        $user = User::find($admin->user_id);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->gender = $request->gender;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); 
        }
        $user->save();

        // Update the admin record
        $admin = Admin::find($admin->id);
        $admin->nama = $request->nama;
        $admin->nip = $request->nip;
        $admin->save();

        return redirect()->route('admin.index')->with('success-edit', 'Admin data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Admin::destroy($admin->id);
        User::destroy($admin->user_id);
        return redirect('/admin')->with('success-hapus', 'Data admin berhasil dihapus.');
    }
}
