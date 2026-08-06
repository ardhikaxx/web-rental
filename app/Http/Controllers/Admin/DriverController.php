<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query();
        if ($request->filled('q')) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$request->q}%")->orWhere('phone', 'like', "%{$request->q}%"));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return view('admin.drivers.index', ['drivers' => $query->paginate(15)->withQueryString()]);
    }

    public function create()
    {
        return view('admin.drivers.form', ['driver' => new Driver()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $driver = Driver::create(array_merge($data, [
            'code' => 'D' . str_pad((string) (Driver::withTrashed()->count() + 1), 3, '0', STR_PAD_LEFT),
            'created_by' => auth()->id(),
        ]));
        if ($request->hasFile('photo')) {
            $driver->update(['photo' => $request->file('photo')->store('drivers', 'public')]);
        }
        $this->log('create', 'driver', 'Driver ' . $driver->name . ' ditambahkan.', $driver);
        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil ditambahkan.');
    }

    public function show(Driver $driver)
    {
        return view('admin.drivers.show', ['driver' => $driver->load('bookings')]);
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.form', ['driver' => $driver]);
    }

    public function update(Request $request, Driver $driver)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('drivers', 'public');
        }
        $driver->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'driver', 'Driver ' . $driver->name . ' diperbarui.', $driver);
        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        $this->log('delete', 'driver', 'Driver ' . $driver->name . ' dihapus.', $driver);
        $driver->delete();
        return back()->with('success', 'Driver dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'license_number' => ['nullable', 'string'],
            'license_expired_at' => ['nullable', 'date'],
            'license_type' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'experience' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}