    <h1>Create New Spare Part</h1>
    <form action="{{ route('spare-parts.store') }}" method="POST">
        @csrf
        <div>
            <label for="part_name">Part Name:</label>
            <input type="text" name="part_name" id="part_name" required>
        </div>
        <div>
            <label for="part_description">Part Description:</label>
            <textarea name="part_description" id="part_description"></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required>
        </div>
        <div>
            <label for="quantity_in_stock">Quantity in Stock:</label>
            <input type="number" name="quantity_in_stock" id="quantity_in_stock" required>
        </div>
        <button type="submit">Create Spare Part</button>
    </form>
