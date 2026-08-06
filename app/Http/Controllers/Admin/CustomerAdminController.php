<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'));
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$request->q}%")->orWhere('email', 'like', "%{$request->q}%")->orWhere('phone', 'like', "%{$request->q}%"));
        }
        $customers = $query->withCount(['bookings as total_bookings'])->withSum(['bookings as total_spent' => fn ($q) => $q->where('status', '!=', 'dibatalkan')], 'total_price')->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        abort_unless($user->hasRole('customer'), 404);
        return view('admin.customers.show', [
            'customer' => $user->load(['bookings.fleet', 'payments']),
        ]);
    }

    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);
        $this->log('delete', 'customer', 'Pelanggan ' . $user->name . ' dinonaktifkan.', $user);
        return back()->with('success', 'Pelanggan dinonaktifkan.');
    }
}