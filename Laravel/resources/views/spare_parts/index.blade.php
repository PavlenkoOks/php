<div class="container">
    <h1>Spare Parts</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('spare_parts.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="part_name" class="form-label">Part Name</label>
                    <input type="text" class="form-control" id="part_name" name="part_name" value="{{ request('part_name') }}">
                </div>
                <div class="col-md-3">
                    <label for="part_description" class="form-label">Part Description</label>
                    <input type="text" class="form-control" id="part_description" name="part_description" value="{{ request('part_description') }}">
                </div>
                <div class="col-md-2">
                    <label for="min_price" class="form-label">Min Price</label>
                    <input type="number" step="0.01" class="form-control" id="min_price" name="min_price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_price" class="form-label">Max Price</label>
                    <input type="number" step="0.01" class="form-control" id="max_price" name="max_price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <label for="min_quantity" class="form-label">Min Quantity</label>
                    <input type="number" class="form-control" id="min_quantity" name="min_quantity" value="{{ request('min_quantity') }}">
                </div>
                <div class="col-md-2">
                    <label for="max_quantity" class="form-label">Max Quantity</label>
                    <input type="number" class="form-control" id="max_quantity" name="max_quantity" value="{{ request('max_quantity') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('spare_parts.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('spare_parts.create') }}" class="btn btn-success">Create New Spare Part</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Part Name</th>
                    <th>Part Description</th>
                    <th>Price</th>
                    <th>Quantity in Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spareParts as $sparePart)
                    <tr>
                        <td>{{ $sparePart->part_name }}</td>
                        <td>{{ $sparePart->part_description }}</td>
                        <td>{{ $sparePart->price }}</td>
                        <td>{{ $sparePart->quantity_in_stock }}</td>
                        <td>
                            <a href="{{ route('spare_parts.edit', $sparePart) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('spare_parts.destroy', $sparePart) }}" method="POST" class="d-inline">
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

    @include('partials.pagination', ['items' => $spareParts])
</div>
