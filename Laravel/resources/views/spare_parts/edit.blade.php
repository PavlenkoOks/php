    <h1>Edit Spare Part</h1>
    <form action="{{ route('spare-parts.update', $sparePart) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="part_name">Part Name:</label>
            <input type="text" name="part_name" id="part_name" value="{{ $sparePart->part_name }}" required>
        </div>
        <div>
            <label for="part_description">Part Description:</label>
            <textarea name="part_description" id="part_description">{{ $sparePart->part_description }}</textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ $sparePart->price }}" required>
        </div>
        <div>
            <label for="quantity_in_stock">Quantity in Stock:</label>
            <input type="number" name="quantity_in_stock" id="quantity_in_stock" value="{{ $sparePart->quantity_in_stock }}" required>
        </div>
        <button type="submit">Update Spare Part</button>
    </form>
