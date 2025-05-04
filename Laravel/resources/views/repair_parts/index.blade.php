    <h1>Repair Parts</h1>
    <a href="{{ route('repair_parts.create') }}">Create New Repair Part</a>
    <table>
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
                    <td>{{ $repairPart->repair->repair_type }}</td>
                    <td>{{ $repairPart->sparePart->part_name }}</td>
                    <td>{{ $repairPart->quantity_used }}</td>
                    <td>{{ $repairPart->total_cost }}</td>
                    <td>
                        <a href="{{ route('repair_parts.edit', $repairPart->id) }}">Edit</a>
                        <form action="{{ route('repair_parts.destroy', $repairPart->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> 