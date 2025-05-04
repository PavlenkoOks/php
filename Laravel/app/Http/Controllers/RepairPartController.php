<?php 
namespace App\Http\Controllers;

use App\Models\RepairPart;
use App\Models\Repair;
use App\Models\SparePart;
use Illuminate\Http\Request;

class RepairPartController
{
    public function index(Request $request)
    {
        $query = RepairPart::query();

        if ($request->has('repair_id')) {
            $query->where('repair_id', $request->repair_id);
        }

        if ($request->has('part_id')) {
            $query->where('part_id', $request->part_id);
        }

        if ($request->has('min_quantity')) {
            $query->where('quantity_used', '>=', $request->min_quantity);
        }
        if ($request->has('max_quantity')) {
            $query->where('quantity_used', '<=', $request->max_quantity);
        }

        if ($request->has('min_total_cost')) {
            $query->where('total_cost', '>=', $request->min_total_cost);
        }
        if ($request->has('max_total_cost')) {
            $query->where('total_cost', '<=', $request->max_total_cost);
        }

        $perPage = $request->input('per_page', 10);
        $repairParts = $query->with(['repair', 'sparePart'])->paginate($perPage);
        $repairs = Repair::all();
        $spareParts = SparePart::all();
        
        return view('repair_parts.index', compact('repairParts', 'repairs', 'spareParts'));
    }

    public function create()
    {
        $repairs = Repair::all();
        return view('repair_parts.create', compact('repairs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'repair_id' => 'required|exists:repairs,id',
        ]);

        RepairPart::create($request->all());
        return redirect()->route('repair-parts.index');
    }

    public function edit(RepairPart $repairPart)
    {
        $repairs = Repair::all();
        return view('repair_parts.edit', compact('repairPart', 'repairs'));
    }

    public function update(Request $request, RepairPart $repairPart)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'repair_id' => 'required|exists:repairs,id',
        ]);

        $repairPart->update($request->all());
        return redirect()->route('repair-parts.index');
    }

    public function destroy(RepairPart $repairPart)
    {
        $repairPart->delete();
        return redirect()->route('repair-parts.index');
    }
}
