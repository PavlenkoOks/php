<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD</title>
</head>
<body>
    <nav>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('cars.index') }}">Cars</a>
        <a href="{{ route('spare-parts.index') }}">Spare Parts</a>
        <a href="{{ route('repairs.index') }}">Repairs</a>
        <a href="{{ route('repair-parts.index') }}">Repair Parts</a>
    </nav>

    <div>
        @yield('content')
    </div>
</body>
</html>
