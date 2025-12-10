<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Travel Preferences') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                {{-- Flash message --}}
                @if(session('status'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('traveler.travel_preferences.update') }}">
                    @csrf

                    {{-- Travel Style --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Travel Style</label>
                        <input type="text" name="travel_style"
                               value="{{ old('travel_style', $preference->travel_style) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Budget Level --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Budget Level</label>
                        <input type="text" name="budget_level"
                               value="{{ old('budget_level', $preference->budget_level) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Preferred Activities --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Preferred Activities</label>
                        <input type="text" name="preferred_activities"
                               value="{{ old('preferred_activities', $preference->preferred_activities) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Preferred Countries --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Preferred Countries</label>
                        <input type="text" name="preferred_countries"
                               value="{{ old('preferred_countries', $preference->preferred_countries) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Notes --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Notes</label>
                        <textarea name="notes"
                                  class="w-full border rounded px-3 py-2"
                                  rows="4">{{ old('notes', $preference->notes) }}</textarea>
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Preferences
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>