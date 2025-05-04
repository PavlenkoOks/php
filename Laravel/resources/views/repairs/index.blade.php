    <h1>Repairs</h1>
    <a href="{{ route('repairs.create') }}">Create New Repair</a>
    <table>
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
                    <td>{{ $repair->car->brand }} {{ $repair->car->model }}</td>
                    <td>{{ $repair->repair_date }}</td>
                    <td>{{ $repair->repair_type }}</td>
                    <td>{{ $repair->cost }}</td>
                    <td>
                        <a href="{{ route('repairs.edit', $repair->id) }}">Edit</a>
                        <form action="{{ route('repairs.destroy', $repair->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 