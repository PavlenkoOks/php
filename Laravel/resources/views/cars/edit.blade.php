    <h1>Edit Car</h1>
    <form action="{{ route('cars.update', $car->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" value="{{ $car->brand }}" required>
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" value="{{ $car->model }}" required>
        </div>
        <div>
            <label for="year">Year:</label>
            <input type="number" name="year" id="year" value="{{ $car->year }}" required>
        </div>
        <div>
            <label for="registration_number">Registration Number:</label>
            <input type="text" name="registration_number" id="registration_number" value="{{ $car->registration_number }}" required>
        </div>
        <div>
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $car->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit">Update Car</button>
    </form> 