<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Super Admin: Lihat semua user
    public function index()
    {
        $users = User::with('role')->get();
        return view('super_admin.users.index', ['users' => $users]);
    }

    // Super Admin: Form tambah user
    public function create()
    {
        $roles = Role::all();
        return view('super_admin.users.create', ['roles' => $roles]);
    }

    // Super Admin: Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Super Admin: Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('super_admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    // Super Admin: Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = $request->only('name', 'email', 'role_id');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Super Admin: Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
