<x-layout>
<x-setting heading="Add New Customer">

	<form method="POST" action="{{ route('store') }}">
	    @csrf
        <x-form.input name="name" />
	    <x-form.textarea name="address">{{ old('address') }}</x-form.textarea>
        <x-form.input name="number"/>

        <x-form.button>Add</x-form.button>
	</form>

</x-setting>
</x-layout>


