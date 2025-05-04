<div class="container">
    <h1>Repairs</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('repairs.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="car_id" class="form-label">Car</label>
                    <select class="form-select" id="car_id" name="car_id">
                        <option value="">All Cars</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->model }} ({{ $car->registration_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="repair_date" class="form-label">Repair Date</label>
                    <input type="date" class="form-control" id="repair_date" name="repair_date" value="{{ request('repair_date') }}">
                </div>
                <div class="col-md-2">
                    <label for="repair_type" class="form-label">Repair Type</label>
                    <input type="text" class="form-control" id="repair_type" name="repair_type" value="{{ request('repair_type') }}">
                </div>
                <div class="col-md-2">
                    <label for="min_cost" class="form-label">Min Cost</label>
                    <input type="number" step="0.01" class="form-control" id="min_cost" name="min_cost" value="{{ request('min_cost') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_cost" class="form-label">Max Cost</label>
                    <input type="number" step="0.01" class="form-control" id="max_cost" name="max_cost" value="{{ request('max_cost') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('repairs.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('repairs.create') }}" class="btn btn-success">Create New Repair</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Car</th>
                    <th>Repair Date</th>
                    <th>Repair Type</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repairs as $repair)
                    <tr>
                        <td>{{ $repair->car->brand }} {{ $repair->car->model }} ({{ $repair->car->registration_number }})</td>
                        <td>{{ $repair->repair_date }}</td>
                        <td>{{ $repair->repair_type }}</td>
                        <td>{{ $repair->cost }}</td>
                        <td>
                            <a href="{{ route('repairs.edit', $repair) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('repairs.destroy', $repair) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('partials.pagination', ['items' => $repairs])
</div>
