<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
    <h3>Edit: {{ $customer->name }}</h3>
    {{-- <form method="POST" action="/customers/{{ $customer->id }}"> --}}
    <form method="POST" action="/api/customers/{{ $customer->id }}">
	    @csrf
	    @method('PATCH')

        {{-- name --}}
        <div>
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
		for="name">
	        {{ ucwords('name') }}
        </label>
        <input class="border border-gray-200 p-2 w-full rounded"
		name="name"
		id="name"
        value="{{ $customer->name }}">
        @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        </div>

        {{-- address --}}
        <div>
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
		for="address">
	        {{ ucwords('address') }}
        </label>
        <input class="border border-gray-200 p-2 w-full rounded"
		name="address"
		id="address"
        value="{{ $customer->address }}">
        @error('address')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        </div>


        {{-- Number --}}
        <div class="mt-2">
            <label for="number">Phone Number</label>
            <input type="number" name="number" id="number" placeholder="{{ $customer->number }}" required>
            @error('number')
                {{ $message }}
            @enderror
        </div>
        <div>
            <button type="submit">Edit</button>
        </div>

    </form>

</body>
</html>