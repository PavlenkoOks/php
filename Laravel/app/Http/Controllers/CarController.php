<?php 
namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Request;

class CarController
{
    public function index()
    {
        $cars = Car::with('customer')->get();
        return view('cars.index', compact('cars'));
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
