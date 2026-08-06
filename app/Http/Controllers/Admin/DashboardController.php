<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthStart = now()->startOfMonth();
        $bookings = Booking::query();

        $stats = [
            'total_revenue' => $bookings->where('status', '!=', 'dibatalkan')->sum('total_price'),
            'month_revenue' => Booking::where('status', '!=', 'dibatalkan')->where('created_at', '>=', $monthStart)->sum('total_price'),
            'total_bookings' => $bookings->count(),
            'pending_bookings' => Booking::whereIn('status', ['menunggu_konfirmasi', 'menunggu_pembayaran'])->count(),
            'active_trips' => Booking::where('status', 'berjalan')->count(),
            'fleet_count' => Fleet::count(),
            'fleet_available' => Fleet::where('status', 'tersedia')->count(),
            'driver_count' => Driver::where('is_active', true)->count(),
            'customer_count' => User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->count(),
            'maintenance_month' => Maintenance::whereDate('date', '>=', now()->startOfMonth())->sum('cost'),
            'occupied' => Fleet::whereIn('status', ['dipesan', 'berjalan'])->count(),
        ];

        $recentBookings = Booking::with(['fleet', 'driver'])->latest()->take(8)->get();
        $topFleets = Fleet::withCount(['bookings as booking_count' => fn ($q) => $q->where('status', '!=', 'dibatalkan')])
            ->orderByDesc('booking_count')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'topFleets'));
    }

    public function chartData()
    {
        $month = now()->month;
        $year = now()->year;

        // daily revenue for this month
        $daily = Booking::where('status', '!=', 'dibatalkan')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get(['created_at', 'total_price'])
            ->groupBy(fn ($b) => $b->created_at->format('d'))
            ->map(fn ($g) => round($g->sum('total_price'), 0))
            ->toArray();

        $monthlyRevenue = collect(range(1, 12))->map(fn ($m) => (float) Booking::where('status', '!=', 'dibatalkan')
            ->whereYear('created_at', $year)->whereMonth('created_at', $m)->sum('total_price'))->toArray();

        $monthlyBookings = collect(range(1, 12))->map(fn ($m) => Booking::whereYear('created_at', $year)->whereMonth('created_at', $m)->count())->toArray();

        $topFleets = Fleet::withCount(['bookings as c' => fn ($q) => $q->where('status', '!=', 'dibatalkan')])
            ->orderByDesc('c')->take(6)->get()->map(fn ($f) => ['label' => $f->brand . ' ' . $f->model, 'value' => $f->c]);

        $statusDist = collect(Booking::statuses())->map(function ($label, $code) {
            return ['status' => $code, 'jumlah' => Booking::where('status', $code)->count()];
        })->values();

        $occupancy = Fleet::count() > 0 ? round(Fleet::whereIn('status', ['dipesan', 'berjalan'])->count() / max(1, Fleet::count()) * 100) : 0;

        $driverPerformance = Driver::select('id', 'name', 'experience_trips', 'rating')->orderByDesc('rating')->take(5)->get()
            ->map(fn ($d) => ['name' => $d->name, 'trips' => $d->experience_trips, 'rating' => (float) $d->rating]);

        return response()->json([
            'daily' => $daily,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyBookings' => $monthlyBookings,
            'topFleets' => $topFleets,
            'status' => $statusDist,
            'occupancy' => $occupancy,
            'drivers' => $driverPerformance,
            'months' => collect(range(1, 12))->map(fn ($m) => Carbon::create()->month($m)->translatedFormat('M'))->toArray(),
        ]);
    }
}