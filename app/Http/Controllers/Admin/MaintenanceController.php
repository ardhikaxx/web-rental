<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('fleet');
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('fleet_id')) {
            $query->where('fleet_id', $request->fleet_id);
        }
        return view('admin.maintenances.index', [
            'maintenances' => $query->latest()->paginate(15)->withQueryString(),
            'fleets' => Fleet::all(),
            'types' => Maintenance::types(),
        ]);
    }

    public function create()
    {
        return view('admin.maintenances.form', [
            'maintenance' => new Maintenance(),
            'fleets' => Fleet::all(),
            'types' => Maintenance::types(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fleet_id' => ['required', 'exists:fleets,id'],
            'type' => ['required'],
            'date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable'],
            'workshop' => ['nullable'],
            'mileage' => ['nullable', 'integer'],
            'next_maintenance_at' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
        ]);
        $maintenance = Maintenance::create(array_merge($data, [
            'code' => 'MTC-' . now()->format('Ymd') . '-' . str_pad((string) (Maintenance::withTrashed()->count() + 1), 4, '0', STR_PAD_LEFT),
            'created_by' => auth()->id(),
        ]));

        if ($maintenance->type == 'servis' || $maintenance->type == 'perbaikan' || $maintenance->type == 'ganti_oli') {
            $maintenance->fleet->update(['status' => 'maintenance']);
        }

        $this->log('create', 'maintenance', 'Maintenance ' . $maintenance->code . ' dicatat.', $maintenance);
        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance berhasil dicatat.');
    }

    public function edit(Maintenance $maintenance)
    {
        return view('admin.maintenances.form', [
            'maintenance' => $maintenance,
            'fleets' => Fleet::all(),
            'types' => Maintenance::types(),
        ]);
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $data = $request->validate([
            'fleet_id' => ['required', 'exists:fleets,id'],
            'type' => ['required'],
            'date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'workshop' => ['nullable'],
            'mileage' => ['nullable', 'integer'],
            'next_maintenance_at' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
        ]);
        $maintenance->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'maintenance', 'Maintenance ' . $maintenance->code . ' diperbarui.', $maintenance);
        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $this->log('delete', 'maintenance', 'Maintenance ' . $maintenance->code . ' dihapus.', $maintenance);
        $maintenance->delete();
        if ($maintenance->fleet && $maintenance->fleet->status === 'maintenance') {
            $maintenance->fleet->update(['status' => 'tersedia']);
        }
        return back()->with('success', 'Maintenance dihapus.');
    }
}