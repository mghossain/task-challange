@props(['heading'])

<section class="py-8 max-w-4xl mx-auto">
	<h1 class="font-bold text-lg mb-8 pb-2 border-b">
		{{ $heading }}
	</h1>
	<div class="flex">
		<aside class="w-48 flex-shrink-0">
			<h4 class="font-semibold mb-4">Links</h4>
			<ul>
				<li>
					<a href="{{route('index')}}" class="{{ request()->routeIs('index') ? 'text-blue-500' : '' }}">All Customers</a>
				</li>
				<li>
					<a href="/create" class="{{ request()->routeIs('create') ? 'text-blue-500' : '' }}">New Customer</a>
				</li>
			</ul>
		</aside>
		<main class="flex-1">
			<x-panel>
				{{ $slot }}
			</x-panel>
		</main>
	</div>

</section>