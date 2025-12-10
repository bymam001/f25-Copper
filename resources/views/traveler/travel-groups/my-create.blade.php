<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a Travel Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('traveler.travel_groups.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 font-medium text-gray-800 dark:text-gray-200">
                            Group Name
                        </label>
                        <input type="text" name="name"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Example: Williamsburg Weekend Trip"
                               required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Create Group
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>