<?php 
namespace App\Http\Controllers;

use App\Models\RepairPart;
use App\Models\Repair;
use Illuminate\Http\Request;

class RepairPartController
{
    public function index()
    {
        $repairParts = RepairPart::with('repair')->get();
        return view('repair_parts.index', compact('repairParts'));
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
