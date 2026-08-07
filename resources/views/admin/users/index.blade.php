@extends('layouts.admin')
@section('title', 'Manajemen User')

@section('content')
    <div class="card card-grid">
        <x-table-toolbar title="Manajemen User" :searchable="false" addUrl="{{ route('admin.users.create') }}" addLabel="Tambah User" addTitle="Tambah User Baru"></x-table-toolbar>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>Nama</th><th>Email</th><th>No HP</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td><span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="d-inline delete-form">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-ban"></i></button></form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection