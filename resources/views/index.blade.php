<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Customers</h1>

    <ul>
        @foreach ($customers as $customer)
            <a href="users/{{ $customer->id }}/edit">
                <li>{{ $customer->name }}</li>
            </a>
            <span>
                <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete!</button>
                </form>
            </span>
        @endforeach
    </ul>
    <form method="GET" action="/users/create">
        <button type="submit">Create a New Customer!</button>
    </form>


    {{-- <form action="/numvalidate" method="post">
        @csrf
        <label for="number">Phone Number</label>
        <input type="number" name="number" id="number" placeholder="Phone Number" required>
        <button type="submit">Validate</button>
        @error('number')
            {{ $message }}
        @enderror
    </form> --}}


</body>
</html>