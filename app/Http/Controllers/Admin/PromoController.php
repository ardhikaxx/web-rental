<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Promo;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        return view('admin.promos.index', ['promos' => Promo::latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.promos.form', [
            'promo' => new Promo(),
            'fleets' => Fleet::all(),
            'tours' => TourPackage::all(),
            'types' => Promo::types(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $promo = Promo::create(array_merge($data, ['created_by' => auth()->id()]));
        $this->log('create', 'promo', 'Promo ' . $promo->name . ' dibuat.', $promo);
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dibuat.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.form', [
            'promo' => $promo,
            'fleets' => Fleet::all(),
            'tours' => TourPackage::all(),
            'types' => Promo::types(),
        ]);
    }

    public function update(Request $request, Promo $promo)
    {
        $data = $this->validateData($request, $promo);
        $promo->update(array_merge($data, ['updated_by' => auth()->id()]));
        $this->log('update', 'promo', 'Promo ' . $promo->name . ' diperbarui.', $promo);
        return redirect()->route('admin.promos.index')->with('success', 'Promo diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $this->log('delete', 'promo', 'Promo ' . $promo->name . ' dihapus.', $promo);
        $promo->delete();
        return back()->with('success', 'Promo dihapus.');
    }

    private function validateData(Request $request, ?Promo $promo = null): array
    {
        $codeRule = 'nullable|unique:promos,code';
        if ($promo) {
            $codeRule .= ',' . $promo->id;
        }
        return $request->validate([
            'name' => ['required'],
            'code' => [$codeRule],
            'type' => ['required', 'in:persen,nominal,voucher'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_purchase' => ['nullable', 'numeric'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'usage_limit' => ['nullable', 'integer'],
            'status' => ['required'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}