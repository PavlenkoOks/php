<?php 
namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Request;

class CarController
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->has('year')) {
            $query->where('year', $request->year);
        }

        if ($request->has('registration_number')) {
            $query->where('registration_number', 'like', '%' . $request->registration_number . '%');
        }

        $perPage = $request->input('per_page', 10);
        $cars = $query->with('customer')->paginate($perPage);
        $customers = Customer::all();
        
        return view('cars.index', compact('cars', 'customers'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('cars.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'license_plate' => 'required|unique:cars',
            'customer_id' => 'required|exists:customers,id',
        ]);

        Car::create($request->all());
        return redirect()->route('cars.index');
    }

    public function edit(Car $car)
    {
        $customers = Customer::all();
        return view('cars.edit', compact('car', 'customers'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'license_plate' => 'required|unique:cars,license_plate,' . $car->id,
            'customer_id' => 'required|exists:customers,id',
        ]);

        $car->update($request->all());
        return redirect()->route('cars.index');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }
}
