    <h1>Create Customer</h1>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone_number">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number"><br>

        <label for="address">Address</label>
        <input type="text" id="address" name="address"><br>

        <button type="submit">Save</button>
    </form>
