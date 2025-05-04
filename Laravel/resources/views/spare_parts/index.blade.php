    <h1>Spare Parts</h1>
    <a href="{{ route('spare-parts.create') }}">Create New Spare Part</a>
    <table>
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
            @foreach ($spareParts as $sparePart)
                <tr>
                    <td>{{ $sparePart->part_name }}</td>
                    <td>{{ $sparePart->part_description }}</td>
                    <td>{{ $sparePart->price }}</td>
                    <td>{{ $sparePart->quantity_in_stock }}</td>
                    <td>
                        <a href="{{ route('spare-parts.edit', $sparePart) }}">Edit</a>
                        <form action="{{ route('spare-parts.destroy', $sparePart) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
