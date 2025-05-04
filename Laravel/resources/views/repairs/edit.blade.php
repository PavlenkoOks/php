    <h1>Edit Repair</h1>
    <form action="{{ route('repairs.update', $repair->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="car_id">Car:</label>
            <select name="car_id" id="car_id" required>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ $repair->car_id == $car->id ? 'selected' : '' }}>
                        {{ $car->brand }} {{ $car->model }} ({{ $car->registration_number }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="repair_date">Repair Date:</label>
            <input type="date" name="repair_date" id="repair_date" value="{{ $repair->repair_date }}" required>
        </div>
        <div>
            <label for="repair_type">Repair Type:</label>
            <input type="text" name="repair_type" id="repair_type" value="{{ $repair->repair_type }}" required>
        </div>
        <div>
            <label for="cost">Cost:</label>
            <input type="number" step="0.01" name="cost" id="cost" value="{{ $repair->cost }}" required>
        </div>
        <button type="submit">Update Repair</button>
    </form> 