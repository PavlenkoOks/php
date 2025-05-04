    <h1>Login</h1>

    <form action="{{ route('login.authenticate') }}" method="POST">
        @csrf

        <label>Email: 
            <input type="email" name="email" required>
        </label><br>

        <label>Password: 
            <input type="password" name="password" required>
        </label><br>

        <button type="submit">Login</button>
    </form>

    @if(session('error'))
        <div>
            <p style="color: red;">{{ session('error') }}</p>
        </div>
    @endif

    <a href="{{ route('register') }}">Don't have an account? Register here.</a>
