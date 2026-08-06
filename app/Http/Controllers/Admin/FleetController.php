<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\FleetCategory;
use App\Models\FleetPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FleetController extends Controller
{
    public function index(Request $request)
    {
        $query = Fleet::with('category');
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('license_plate', 'like', "%{$request->q}%")->orWhere('brand', 'like', "%{$request->q}%")->orWhere('model', 'like', "%{$request->q}%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $fleets = $query->paginate(15)->withQueryString();
        return view('admin.fleets.index', compact('fleets'));
    }

    public function create()
    {
        return view('admin.fleets.form', [
            'fleet' => new Fleet(),
            'categories' => FleetCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $fleet = Fleet::create(array_merge($data, [
            'code' => 'F' . str_pad((string) (Fleet::withTrashed()->count() + 1), 4, '0', STR_PAD_LEFT),
            'created_by' => auth()->id(),
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('fleets', 'public');
                FleetPhoto::create([
                    'fleet_id' => $fleet->id,
                    'path' => $path,
                    'is_primary' => $i === 0,
                ]);
                if ($i === 0) {
                    $fleet->update(['primary_image' => $path]);
                }
            }
        } elseif ($request->filled('primary_image')) {
            $fleet->update(['primary_image' => $request->primary_image]);
        }

        $this->log('create', 'fleet', 'Armada ' . $fleet->license_plate . ' ditambahkan.', $fleet);
        return redirect()->route('admin.fleets.index')->with('success', 'Armada berhasil ditambahkan.');
    }

    public function show(Fleet $fleet)
    {
        return view('admin.fleets.show', ['fleet' => $fleet->load('photos', 'bookings', 'maintenances')]);
    }

    public function edit(Fleet $fleet)
    {
        return view('admin.fleets.form', [
            'fleet' => $fleet,
            'categories' => FleetCategory::all(),
        ]);
    }

    public function update(Request $request, Fleet $fleet)
    {
        $data = $this->validateData($request);
        $fleet->update(array_merge($data, ['updated_by' => auth()->id()]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('fleets', 'public');
                FleetPhoto::create(['fleet_id' => $fleet->id, 'path' => $path, 'is_primary' => $i === 0]);
                if ($i === 0) {
                    $fleet->update(['primary_image' => $path]);
                }
            }
        }

        $this->log('update', 'fleet', 'Armada ' . $fleet->license_plate . ' diperbarui.', $fleet);
        return redirect()->route('admin.fleets.index')->with('success', 'Armada berhasil diperbarui.');
    }

    public function destroy(Fleet $fleet)
    {
        $this->log('delete', 'fleet', 'Armada ' . $fleet->license_plate . ' dihapus.', $fleet);
        $fleet->delete();
        return back()->with('success', 'Armada dihapus.');
    }

    public function categories()
    {
        return view('admin.fleets.categories', ['categories' => FleetCategory::withCount('fleets')->get()]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:fleet_categories,id'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'type' => ['nullable', 'string'],
            'year' => ['required', 'string', 'max:4'],
            'license_plate' => ['required', 'string', 'max:20'],
            'frame_number' => ['nullable', 'string'],
            'engine_number' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'transmission' => ['nullable', 'string'],
            'fuel' => ['nullable', 'string'],
            'daily_price' => ['required', 'numeric', 'min:0'],
            'weekly_price' => ['nullable', 'numeric', 'min:0'],
            'monthly_price' => ['nullable', 'numeric', 'min:0'],
            'price_with_driver' => ['nullable', 'numeric', 'min:0'],
            'price_without_driver' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}