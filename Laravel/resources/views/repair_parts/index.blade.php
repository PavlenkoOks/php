<div class="container">
    <h1>Repair Parts</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('repair_parts.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="repair_id" class="form-label">Repair</label>
                    <select class="form-select" id="repair_id" name="repair_id">
                        <option value="">All Repairs</option>
                        @foreach($repairs as $repair)
                            <option value="{{ $repair->id }}" {{ request('repair_id') == $repair->id ? 'selected' : '' }}>
                                {{ $repair->repair_type }} ({{ $repair->car->brand }} {{ $repair->car->model }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="part_id" class="form-label">Spare Part</label>
                    <select class="form-select" id="part_id" name="part_id">
                        <option value="">All Parts</option>
                        @foreach($spareParts as $sparePart)
                            <option value="{{ $sparePart->id }}" {{ request('part_id') == $sparePart->id ? 'selected' : '' }}>
                                {{ $sparePart->part_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="min_quantity" class="form-label">Min Quantity</label>
                    <input type="number" class="form-control" id="min_quantity" name="min_quantity" value="{{ request('min_quantity') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_quantity" class="form-label">Max Quantity</label>
                    <input type="number" class="form-control" id="max_quantity" name="max_quantity" value="{{ request('max_quantity') }}">
                </div>
                <div class="col-md-2">
                    <label for="min_total_cost" class="form-label">Min Total Cost</label>
                    <input type="number" step="0.01" class="form-control" id="min_total_cost" name="min_total_cost" value="{{ request('min_total_cost') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_total_cost" class="form-label">Max Total Cost</label>
                    <input type="number" step="0.01" class="form-control" id="max_total_cost" name="max_total_cost" value="{{ request('max_total_cost') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('repair_parts.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('repair_parts.create') }}" class="btn btn-success">Create New Repair Part</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Repair</th>
                    <th>Part</th>
                    <th>Quantity Used</th>
                    <th>Total Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repairParts as $repairPart)
                    <tr>
                        <td>{{ $repairPart->repair->repair_type }} ({{ $repairPart->repair->car->brand }} {{ $repairPart->repair->car->model }})</td>
                        <td>{{ $repairPart->sparePart->part_name }}</td>
                        <td>{{ $repairPart->quantity_used }}</td>
                        <td>{{ $repairPart->total_cost }}</td>
                        <td>
                            <a href="{{ route('repair_parts.edit', $repairPart) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('repair_parts.destroy', $repairPart) }}" method="POST" class="d-inline">
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

    @include('partials.pagination', ['items' => $repairParts])
</div>
