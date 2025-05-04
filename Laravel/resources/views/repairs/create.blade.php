    <h1>Create New Repair</h1>
    <form action="{{ route('repairs.store') }}" method="POST">
        @csrf
        <div>
            <label for="car_id">Car:</label>
            <select name="car_id" id="car_id" required>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->brand }} {{ $car->model }} ({{ $car->registration_number }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="repair_date">Repair Date:</label>
            <input type="date" name="repair_date" id="repair_date" required>
        </div>
        <div>
            <label for="repair_type">Repair Type:</label>
            <input type="text" name="repair_type" id="repair_type" required>
        </div>
        <div>
            <label for="cost">Cost:</label>
            <input type="number" step="0.01" name="cost" id="cost" required>
        </div>
        <button type="submit">Create Repair</button>
    </form>
