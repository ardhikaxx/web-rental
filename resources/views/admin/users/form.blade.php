@extends('layouts.admin')
@section('title', $user->exists ? 'Edit User' : 'Tambah User')

@section('content')
<form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
    @csrf
    @if($user->exists) @method('put') @endif
    <div class="card card-grid" style="max-width:640px">
        <div class="card-header bg-white fw-bold">Data User</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Nama</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">No HP</label><input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control"></div>
            <div class="col-12"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></div>
            @if(!$user->exists)
            <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
            @endif
            <div class="col-md-6"><label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            @if($user->exists)
            <div class="col-md-6"><label class="form-label">Aktif</label>
                <select name="is_active" class="form-select">
                    <option value="1" @selected($user->is_active)>Ya</option>
                    <option value="0" @selected(!$user->is_active)>Tidak</option>
                </select>
            </div>
            @endif
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-brand"><i class="fa-solid fa-save me-2"></i>Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection