<?php 
namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController
{
    public function index()
    {
        $spareParts = SparePart::all();
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
