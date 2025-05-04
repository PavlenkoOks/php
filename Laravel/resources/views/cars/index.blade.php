    <h1>Cars</h1>
    <a href="{{ route('cars.create') }}">Create New Car</a>
    <table>
        <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Registration Number</th>
                <th>Customer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->registration_number }}</td>
                    <td>{{ $car->customer->first_name }} {{ $car->customer->last_name }}</td>
                    <td>
                        <a href="{{ route('cars.edit', $car) }}">Edit</a>
                        <form action="{{ route('cars.destroy', $car) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 