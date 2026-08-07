@extends('layouts.admin')
@section('title', 'Activity Logs')

@section('content')
<div class="card card-grid">
    <x-table-toolbar title="Activity Logs" :searchable="false" filter="filter">
        <select name="module" class="form-select form-select-sm" style="width:auto">
            <option value="">Semua Modul</option>
            @foreach ($modules as $m)<option value="{{ $m }}" @selected(request('module')==$m)>{{ ucfirst($m) }}</option>@endforeach
        </select>
        <select name="action" class="form-select form-select-sm" style="width:auto">
            <option value="">Semua Aksi</option>
            @foreach ($actions as $a)<option value="{{ $a }}" @selected(request('action')==$a)>{{ $a }}</option>@endforeach
        </select>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm" style="width:auto">
        <span class="text-muted small">s.d.</span>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm" style="width:auto">
    </x-table-toolbar>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead><tr><th>User</th><th>Role</th><th>Aksi</th><th>Modul</th><th>Deskripsi</th><th>IP</th><th>Waktu</th></tr></thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->user_name }}</td>
                        <td><span class="badge bg-secondary">{{ $log->role_name }}</span></td>
                        <td><span class="badge bg-info text-dark">{{ $log->action }}</span></td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ format_indo_date($log->created_at) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</div>
@endsection