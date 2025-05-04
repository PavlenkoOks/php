    <h1>Edit Repair Part</h1>
    <form action="{{ route('repair_parts.update', $repairPart->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="repair_id">Repair:</label>
            <select name="repair_id" id="repair_id" required>
                @foreach($repairs as $repair)
                    <option value="{{ $repair->id }}" {{ $repairPart->repair_id == $repair->id ? 'selected' : '' }}>
                        {{ $repair->repair_type }} ({{ $repair->car->brand }} {{ $repair->car->model }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="part_id">Spare Part:</label>
            <select name="part_id" id="part_id" required>
                @foreach($spareParts as $sparePart)
                    <option value="{{ $sparePart->id }}" {{ $repairPart->part_id == $sparePart->id ? 'selected' : '' }}>
                        {{ $sparePart->part_name }} ({{ $sparePart->price }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="quantity_used">Quantity Used:</label>
            <input type="number" name="quantity_used" id="quantity_used" value="{{ $repairPart->quantity_used }}" required>
        </div>
        <div>
            <label for="total_cost">Total Cost:</label>
            <input type="number" step="0.01" name="total_cost" id="total_cost" value="{{ $repairPart->total_cost }}" required>
        </div>
        <button type="submit">Update Repair Part</button>
    </form> 