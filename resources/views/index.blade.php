<x-layout>
    <x-setting heading="Manage Customers">

    <div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">

          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($customers as $customer )
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="text-sm font-medium text-gray-900">
                        <a href="/users/{{ $customer->id}}">
                            {{ $customer->name }}</a>
                    </div>
                </div>
              </td>
              {{-- <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"></span></td> --}}
              {{-- <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Published
                </span>
              </td> --}}
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="users/{{ $customer->id }}/edit" class="text-blue-500 hover:text-blue-600">Edit</a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <form method="POST" action="{{ route('destroy', $customer->id) }}">
                    @csrf
                    @method('DELETE')

                    <button class="text-xs text-gray-400 hover:text-gray-500">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="mt-4")>
      {{ $customers->links() }}
</div>
</x-setting>
</x-layout>