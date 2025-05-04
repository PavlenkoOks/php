    <h1>Create New Repair Part</h1>
    <form action="{{ route('repair_parts.store') }}" method="POST">
        @csrf
        <div>
            <label for="repair_id">Repair:</label>
            <select name="repair_id" id="repair_id" required>
                @foreach($repairs as $repair)
                    <option value="{{ $repair->id }}">{{ $repair->repair_type }} ({{ $repair->car->brand }} {{ $repair->car->model }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="part_id">Spare Part:</label>
            <select name="part_id" id="part_id" required>
                @foreach($spareParts as $sparePart)
                    <option value="{{ $sparePart->id }}">{{ $sparePart->part_name }} ({{ $sparePart->price }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="quantity_used">Quantity Used:</label>
            <input type="number" name="quantity_used" id="quantity_used" required>
        </div>
        <div>
            <label for="total_cost">Total Cost:</label>
            <input type="number" step="0.01" name="total_cost" id="total_cost" required>
        </div>
        <button type="submit">Create Repair Part</button>
    </form> 