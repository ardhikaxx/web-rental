<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::query();
        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        return view('admin.tours.index', ['tours' => $query->latest()->paginate(15)->withQueryString()]);
    }

    public function create()
    {
        return view('admin.tours.form', ['tour' => new TourPackage()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $tour = TourPackage::create(array_merge($data, [
            'slug' => Str::slug($data['name']) . '-' . Str::random(4),
            'created_by' => auth()->id(),
        ]));
        if ($request->hasFile('thumbnail')) {
            $tour->update(['thumbnail' => $request->file('thumbnail')->store('tours', 'public')]);
        }
        $this->log('create', 'tour', 'Paket wisata ' . $tour->name . ' ditambahkan.', $tour);
        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    public function edit(TourPackage $tour)
    {
        return view('admin.tours.form', ['tour' => $tour]);
    }

    public function update(Request $request, TourPackage $tour)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('tours', 'public');
        }
        $tour->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'tour', 'Paket wisata ' . $tour->name . ' diperbarui.', $tour);
        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata diperbarui.');
    }

    public function destroy(TourPackage $tour)
    {
        $this->log('delete', 'tour', 'Paket wisata ' . $tour->name . ' dihapus.', $tour);
        $tour->delete();
        return back()->with('success', 'Paket wisata dihapus.');
    }

    public function storeSchedule(Request $request, TourPackage $tour)
    {
        $data = $request->validate([
            'departure_date' => ['required', 'date'],
            'quota' => ['required', 'integer', 'min:1'],
            'status' => ['required'],
        ]);
        TourSchedule::create($data + ['tour_package_id' => $tour->id]);
        return back()->with('success', 'Jadwal keberangkatan ditambahkan.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required'],
            'destination' => ['nullable'],
            'duration_days' => ['required', 'integer'],
            'duration_nights' => ['nullable', 'integer'],
            'price_per_person' => ['required', 'numeric'],
            'price_per_group' => ['nullable', 'numeric'],
            'min_group' => ['nullable', 'integer'],
            'max_group' => ['nullable', 'integer'],
            'description' => ['nullable'],
            'itinerary' => ['nullable'],
            'facilities' => ['nullable'],
            'terms' => ['nullable'],
            'status' => ['required'],
        ]);
    }
}