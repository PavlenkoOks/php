<?php 
namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController
{
    public function index(Request $request)
    {
        $query = SparePart::query();

        if ($request->has('part_name')) {
            $query->where('part_name', 'like', '%' . $request->part_name . '%');
        }

        if ($request->has('part_description')) {
            $query->where('part_description', 'like', '%' . $request->part_description . '%');
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('min_quantity')) {
            $query->where('quantity_in_stock', '>=', $request->min_quantity);
        }
        if ($request->has('max_quantity')) {
            $query->where('quantity_in_stock', '<=', $request->max_quantity);
        }

        $perPage = $request->input('per_page', 10);
        $spareParts = $query->paginate($perPage);
        
        return view('spare_parts.index', compact('spareParts'));
    }

    public function create()
    {
        return view('spare_parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
        ]);

        SparePart::create($request->all());
        return redirect()->route('spare-parts.index');
    }

    public function edit(SparePart $sparePart)
    {
        return view('spare_parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $sparePart->update($request->all());
        return redirect()->route('spare-parts.index');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();
        return redirect()->route('spare-parts.index');
    }
}
