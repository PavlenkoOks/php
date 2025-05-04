<?php 
namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Car;
use Illuminate\Http\Request;

class RepairController
{
    public function index()
    {
        $repairs = Repair::with('car')->get();
        return view('repairs.index', compact('repairs'));
    }

    public function create()
    {
        $cars = Car::all();
        return view('repairs.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'car_id' => 'required|exists:cars,id',
        ]);

        Repair::create($request->all());
        return redirect()->route('repairs.index');
    }

    public function edit(Repair $repair)
    {
        $cars = Car::all();
        return view('repairs.edit', compact('repair', 'cars'));
    }

    public function update(Request $request, Repair $repair)
    {
        $request->validate([
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'car_id' => 'required|exists:cars,id',
        ]);

        $repair->update($request->all());
        return redirect()->route('repairs.index');
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();
        return redirect()->route('repairs.index');
    }
}
