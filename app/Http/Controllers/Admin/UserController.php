<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::with('roles')->latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User(), 'roles' => Role::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'whatsapp' => $data['phone'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);
        $user->assignRole($data['role']);
        $this->log('create', 'user', 'User ' . $user->name . ' dibuat dengan role ' . $data['role'], $user);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', ['user' => $user, 'roles' => Role::all()]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable'],
            'role' => ['required', 'exists:roles,name'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'is_active' => (bool) ($data['is_active'] ?? true),
            'updated_by' => auth()->id(),
        ]);
        $user->syncRoles($data['role']);
        $this->log('update', 'user', 'Data user ' . $user->name . ' diperbarui.', $user);
        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->update(['is_active' => false]);
        $this->log('delete', 'user', 'User ' . $user->name . ' dinonaktifkan.', $user);
        return back()->with('success', 'User dinonaktifkan.');
    }
}