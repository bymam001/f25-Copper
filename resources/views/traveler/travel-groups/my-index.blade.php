<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Travel Groups') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                {{-- Flash message --}}
                @if (session('status'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Top bar: Create button --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Your Groups
                    </h3>

                    <a href="{{ route('traveler.travel_groups.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent 
                              rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                              hover:bg-blue-700 active:bg-blue-900 focus:outline-none">
                        + Create New Group
                    </a>
                </div>

                {{-- Groups list --}}
                @forelse ($groups as $group)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-md font-semibold text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('traveler.travel_groups.show', $group) }}" class="underline hover:text-blue-600"> 
                                    {{ $group->name }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Created: {{ $group->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="text-xs text-gray-400">
                                {{-- Later you can add buttons like "Invite friends" or "Open group" here --}}
                                Planning tools coming soon…
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">
                        You don’t have any travel groups yet.  
                        Click <span class="font-semibold">“Create New Group”</span> to start one.
                    </p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>