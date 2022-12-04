<x-layout>
<x-setting :heading="$customer->name">

	<x-form.input name="name" :value="old('name', $customer->name)"/>
	<x-form.textarea name="address">{{ old('address', $customer->address) }} </x-form.textarea>
	<x-form.input name="number" :value="old('number', $customer->number)"/>
	<x-form.input name="countryCode" :value="old('countryCode', $customer->countryCode)"/>
	<x-form.input name="countryName" :value="old('countryName', $customer->countryName)"/>
	<x-form.input name="operatorName" :value="old('operatorName', $customer->operatorName)"/>

</x-setting>
</x-layout>
