<?php 
namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Car;
use Illuminate\Http\Request;

class RepairController
{
    public function index(Request $request)
    {
        $query = Repair::query();

        if ($request->has('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        if ($request->has('repair_date')) {
            $query->whereDate('repair_date', $request->repair_date);
        }

        if ($request->has('repair_type')) {
            $query->where('repair_type', 'like', '%' . $request->repair_type . '%');
        }

        if ($request->has('min_cost')) {
            $query->where('cost', '>=', $request->min_cost);
        }
        if ($request->has('max_cost')) {
            $query->where('cost', '<=', $request->max_cost);
        }

        $perPage = $request->input('per_page', 10);
        $repairs = $query->with(['car', 'car.customer'])->paginate($perPage);
        $cars = Car::all();
        
        return view('repairs.index', compact('repairs', 'cars'));
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
