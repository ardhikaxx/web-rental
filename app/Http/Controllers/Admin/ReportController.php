<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ReportExport;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Maintenance;
use App\Models\Promo;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'totalRevenue' => Booking::where('status', '!=', 'dibatalkan')->sum('total_price'),
            'totalExpense' => Maintenance::sum('cost'),
            'totalBooking' => Booking::count(),
            'totalFleet' => Fleet::count(),
            'totalCustomer' => User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))->count(),
        ]);
    }

    public function booking(Request $request)
    {
        $query = Booking::with(['fleet', 'driver'])->latest();
        if ($request->filled('from')) { $query->whereDate('start_date', '>=', $request->from); }
        if ($request->filled('to')) { $query->whereDate('start_date', '<=', $request->to); }
        if ($request->filled('status') && $request->status !== 'all') { $query->where('status', $request->status); }
        $bookings = $query->paginate(20)->withQueryString();
        return view('reports.booking', ['bookings' => $bookings, 'statuses' => Booking::statuses()]);
    }

    public function revenue(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $rows = Payment::with('booking')
            ->where('status', 'verified')
            ->whereBetween('verified_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->orderBy('verified_at')->get();
        $total = $rows->sum('amount');
        return view('reports.revenue', ['payments' => $rows, 'total' => $total, 'from' => $from, 'to' => $to]);
    }

    public function expense(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        $to = $request->to ?? now()->format('Y-m-d');
        $rows = Maintenance::with('fleet')->whereBetween('date', [$from, $to])->orderBy('date')->get();
        return view('reports.expense', ['maintenances' => $rows, 'total' => $rows->sum('cost'), 'from' => $from, 'to' => $to]);
    }

    public function profitLoss(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        $to = $request->to ?? now()->format('Y-m-d');

        $income = Payment::where('status', 'verified')->whereBetween('verified_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('amount');
        $expense = Maintenance::whereBetween('date', [$from, $to])->sum('cost');
        $discounts = Booking::whereBetween('start_date', [$from, $to])->sum('promo_code_discount');
        $net = $income - $expense;

        $months = collect(range(1, 12))->map(function ($m) {
            return [
                'month' => Carbon::create()->month($m),
                'income' => Payment::where('status', 'verified')->whereMonth('verified_at', $m)->whereYear('verified_at', now()->year)->sum('amount'),
                'expense' => Maintenance::whereMonth('date', $m)->whereYear('date', now()->year)->sum('cost'),
            ];
        });

        return view('reports.profit-loss', compact('from', 'to', 'income', 'expense', 'discounts', 'net', 'months'));
    }

    public function fleet(Request $request)
    {
        $fleets = Fleet::withCount(['bookings as total_bookings' => fn ($q) => $q->where('status', '!=', 'dibatalkan')])
            ->withSum(['bookings as total_revenue' => fn ($q) => $q->where('status', '!=', 'dibatalkan')], 'total_price');
        if ($request->filled('status') && $request->status !== 'all') { $fleets->where('status', $request->status); }
        return view('reports.fleet', ['fleets' => $fleets->get()]);
    }

    public function driver(Request $request)
    {
        $drivers = Driver::withCount(['bookings as total_trips' => fn ($q) => $q->where('status', '!=', 'dibatalkan')])->orderBy('rating', 'desc')->get();
        return view('reports.driver', ['drivers' => $drivers]);
    }

    public function customer(Request $request)
    {
        $customers = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))
            ->withCount(['bookings as total_bookings' => fn ($q) => $q->where('status', '!=', 'dibatalkan')])
            ->withSum(['bookings as total_spent' => fn ($q) => $q->where('status', '!=', 'dibatalkan')], 'total_price')
            ->orderByDesc('total_spent')->get();
        return view('reports.customer', ['customers' => $customers]);
    }

    public function exportPdf(Request $request)
    {
        $type = $request->query('type', 'booking');
        $from = $request->query('from');
        $to = $request->query('to');

        $rows = $this->rowsFor($type, $from, $to);
        $title = 'Laporan ' . strtoupper($type);

        $pdf = Pdf::loadView('reports.pdf', [
            'title' => $title,
            'head' => $rows['headings'],
            'data' => $rows['data'],
            'from' => $from,
            'to' => $to,
        ])->setPaper('a4', 'landscape');

        return $pdf->download($type . '-laporan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $type = $request->query('type', 'booking');
        $rows = $this->rowsFor($type, $request->query('from'), $request->query('to'));

        $export = new ReportExport($rows['headings'], $rows['data']);
        return Excel::download($export, $type . '-laporan-' . now()->format('Ymd-His') . '.xlsx');
    }

    private function rowsFor(string $type, $from = null, $to = null): array
    {
        $query = Booking::with(['fleet', 'driver']);
        if ($from) { $query->whereDate('start_date', '>=', $from); }
        if ($to) { $query->whereDate('start_date', '<=', $to); }

        switch ($type) {
            case 'booking':
                $headings = ['Kode', 'Pelanggan', 'No HP', 'Armada', 'Durasi', 'Tgl. Mulai', 'Tgl. Selesai', 'Total', 'Status'];
                $data = $query->get()->map(fn ($b) => [
                    $b->booking_code, $b->customer_name, $b->customer_phone,
                    optional($b->fleet)->license_plate, $b->duration_days . ' hari',
                    $b->start_date?->format('Y-m-d'), $b->end_date?->format('Y-m-d'),
                    (float) $b->total_price, $b->status,
                ]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            case 'payment':
                $headings = ['No', 'Kode Booking', 'Tipe', 'Jumlah', 'Metode', 'Status', 'Diverifikasi'];
                $data = \App\Models\Payment::with('booking')->whereBetween('created_at', [$from ?? now()->startOfYear(), $to ?? now()->endOfDay()])->get()->map(fn ($p) => [
                    $p->payment_number, optional($p->booking)->booking_code, $p->type, (float) $p->amount, $p->payment_method, $p->status, $p->verified_at?->format('Y-m-d'),
                ]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            case 'fleet':
                $headings = ['Kode', 'Armada', 'Plat', 'Kapasitas', 'Harga Harian', 'Status'];
                $data = Fleet::all()->map(fn ($f) => [$f->code, $f->display_name, $f->license_plate, $f->capacity, (float) $f->daily_price, $f->status]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            case 'driver':
                $headings = ['Nama', 'No HP', 'SIM', 'Rating', 'Perjalanan', 'Status'];
                $data = Driver::all()->map(fn ($d) => [$d->name, $d->phone, $d->license_number, (float) $d->rating, $d->experience_trips, $d->status]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            case 'customer':
                $headings = ['Nama', 'Email', 'No HP', 'Kota', 'Total Booking', 'Total Belanja'];
                $data = User::whereHas('roles', fn ($q) => $q->where('name', 'customer'))
                    ->withSum(['bookings as spent' => fn ($q) => $q->where('status', '!=', 'dibatalkan')], 'total_price')
                    ->get()->map(fn ($c) => [$c->name, $c->email, $c->phone, $c->city, $c->bookings->count(), (float) $c->spent]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            case 'maintenance':
                $headings = ['Kode', 'Armada', 'Jenis', 'Tanggal', 'Biaya', 'Status'];
                $data = Maintenance::with('fleet')->get()->map(fn ($m) => [$m->code, optional($m->fleet)->license_plate, $m->type, $m->date?->format('Y-m-d'), (float) $m->cost, $m->status]);
                return ['headings' => $headings, 'data' => $data->toArray()];

            default:
                $headings = ['Kode', 'Pelanggan', 'Total', 'Status'];
                $data = $query->get()->map(fn ($b) => [$b->booking_code, $b->customer_name, (float) $b->total_price, $b->status]);
                return ['headings' => $headings, 'data' => $data->toArray()];
        }
    }
}