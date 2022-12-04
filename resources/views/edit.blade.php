<x-layout>
<x-setting :heading="'Edit Customer: '.$customer->name">

	<form method="POST" action="{{route('update', $customer->id) }}">
	    @csrf
	    @method('PATCH')
	<x-form.input name="name" :value="old('name', $customer->name)"/>
	<x-form.textarea name="address">{{ old('address', $customer->address) }} </x-form.textarea>
	<x-form.input name="number" :value="old('number', $customer->number)"/>

	<x-form.button>Update</x-form.button>

	</form>

</x-setting>

</x-layout>

