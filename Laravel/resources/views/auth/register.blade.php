    <h1>Register</h1>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <label>Email: 
            <input type="email" name="email" required>
        </label><br>

        <label>Password: 
            <input type="password" name="password" required>
        </label><br>

        <label>Confirm Password: 
            <input type="password" name="password_confirmation" required>
        </label><br>

        <label>Role: 
            <select name="role">
                <option value="Client">Client</option>
                <option value="Manager">Manager</option>
                <option value="Admin">Admin</option>
            </select>
        </label><br>

        <button type="submit">Register</button>
    </form>

    @if(session('error'))
        <div>
            <p style="color: red;">{{ session('error') }}</p>
        </div>
    @endif

    <a href="{{ route('login') }}">Already have an account? Login here.</a>
