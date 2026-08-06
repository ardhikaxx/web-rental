<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\WeddingCar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WeddingController extends Controller
{
    public function index()
    {
        return view('admin.weddings.index', ['weddings' => WeddingCar::latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.weddings.form', ['wedding' => new WeddingCar(), 'fleets' => Fleet::all()]);
    }

    public function store(Request $request)
    {
$data = $request->validate([
            'name' => ['required'],
            'fleet_id' => ['nullable', 'exists:fleets,id'],
            'area' => ['nullable'],
            'rental_price' => ['required', 'numeric'],
            'decoration_price' => ['required', 'numeric'],
            'driver_price' => ['required', 'numeric'],
            'duration_hours' => ['required', 'integer'],
            'decoration_details' => ['nullable'],
        ]);
        $data['total_price'] = $data['rental_price'] + $data['decoration_price'] + $data['driver_price'];
        $wedding = WeddingCar::create(array_merge($data, [
            'slug' => Str::slug($data['name']) . '-' . Str::random(3),
        ]));
        $this->log('create', 'wedding', 'Paket wedding car ' . $wedding->name . ' dibuat.', $wedding);
        return redirect()->route('admin.weddings.index')->with('success', 'Paket wedding car dibuat.');
    }

    public function edit(WeddingCar $wedding)
    {
        return view('admin.weddings.form', ['wedding' => $wedding, 'fleets' => Fleet::all()]);
    }

    public function update(Request $request, WeddingCar $wedding)
    {
        $data = $request->validate([
            'name' => ['required'],
            'fleet_id' => ['nullable', 'exists:fleets,id'],
            'area' => ['nullable'],
            'rental_price' => ['required', 'numeric'],
            'decoration_price' => ['required', 'numeric'],
            'driver_price' => ['required', 'numeric'],
            'duration_hours' => ['required', 'integer'],
            'decoration_details' => ['nullable'],
        ]);
        $data['total_price'] = $data['rental_price'] + $data['decoration_price'] + $data['driver_price'];
        $wedding->update($data);
        $this->log('update', 'wedding', 'Paket wedding car diperbarui.', $wedding);
        return redirect()->route('admin.weddings.index')->with('success', 'Paket wedding car diperbarui.');
    }

    public function destroy(WeddingCar $wedding)
    {
        $this->log('delete', 'wedding', 'Paket wedding car dihapus.', $wedding);
        $wedding->delete();
        return back()->with('success', 'Paket wedding car dihapus.');
    }
}