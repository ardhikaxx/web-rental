<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntercityTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TravelController extends Controller
{
    public function index()
    {
        return view('admin.travel.index', ['travels' => IntercityTravel::latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.travel.form', ['travel' => new IntercityTravel(), 'routes' => IntercityTravel::routes()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'route_origin' => ['required'],
            'route_destination' => ['required', 'different:route_origin'],
            'price' => ['required', 'numeric'],
            'travel_time_hours' => ['required', 'numeric'],
            'departure_time' => ['nullable'],
            'quota' => ['required', 'integer', 'min:1'],
            'pickup_points' => ['nullable'],
            'dropoff_points' => ['nullable'],
        ]);
        $travel = IntercityTravel::create(array_merge($data, [
            'name' => 'Travel ' . $data['route_origin'] . ' - ' . $data['route_destination'],
            'slug' => Str::slug($data['route_origin'] . ' ke ' . $data['route_destination'] . '-' . Str::random(3)),
            'created_by' => auth()->id(),
        ]));
        $this->log('create', 'travel', 'Rute travel ' . $travel->name . ' ditambahkan.', $travel);
        return redirect()->route('admin.travel.index')->with('success', 'Rute travel ditambahkan.');
    }

    public function edit(IntercityTravel $travel)
    {
        return view('admin.travel.form', ['travel' => $travel, 'routes' => IntercityTravel::routes()]);
    }

    public function update(Request $request, IntercityTravel $travel)
    {
        $data = $request->validate([
            'route_origin' => ['required'],
            'route_destination' => ['required', 'different:route_origin'],
            'price' => ['required', 'numeric'],
            'travel_time_hours' => ['required', 'numeric'],
            'departure_time' => ['nullable'],
            'quota' => ['required', 'integer'],
            'pickup_points' => ['nullable'],
            'dropoff_points' => ['nullable'],
        ]);
        $travel->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'travel', 'Rute travel diperbarui.', $travel);
        return redirect()->route('admin.travel.index')->with('success', 'Rute travel diperbarui.');
    }

    public function destroy(IntercityTravel $travel)
    {
        $this->log('delete', 'travel', 'Rute travel dihapus.', $travel);
        $travel->delete();
        return back()->with('success', 'Rute travel dihapus.');
    }
}