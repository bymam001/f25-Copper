@extends('layouts.app')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Refine Your Itinerary</h1>

    {{-- AI refinement form --}}
    <form method="POST" action="{{ route('traveler.itineraries.ai-refine', $itinerary) }}">
        @csrf

        <label for="prompt" class="block font-medium mb-2">
            How would you like to adjust your itinerary?
        </label>

        <textarea 
            id="prompt"
            name="prompt" 
            rows="4" 
            class="w-full border p-3 rounded" 
            placeholder="Provide instructions for refining your itinerary"
            required
        >{{ old('prompt') }}</textarea>

        @error('prompt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <button 
            type="submit"
            class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
            Apply Changes
        </button>
    </form>

    {{-- AI suggested updates (from the latest request) --}}
    @if ($response)
        <div class="mt-6 p-4 bg-gray-100 rounded">
            <h2 class="font-semibold text-lg mb-2">Suggested Updates</h2>
            <p class="whitespace-pre-wrap">{{ $response }}</p>
        </div>
    @endif

    {{-- Current itinerary: always show the real fields from the model --}}
    <div class="mt-6 p-4 bg-gray-50 rounded border">
        <h2 class="font-semibold text-lg mb-2">Current Itinerary</h2>
        <ul class="space-y-1">
            <li>
                <strong>Name:</strong>
                {{ $itinerary->name }}
            </li>
            <li>
                <strong>Description:</strong>
                {{ $itinerary->description ?? '-' }}
            </li>
            <li>
                <strong>Start Date:</strong>
                {{ $itinerary->start_date ? $itinerary->start_date->format('Y-m-d') : '-' }}
            </li>
            <li>
                <strong>End Date:</strong>
                {{ $itinerary->end_date ? $itinerary->end_date->format('Y-m-d') : '-' }}
            </li>
            <li>
                <strong>Destination:</strong>
                {{ $itinerary->destination ?? '-' }}
            </li>
            <li>
                <strong>Location:</strong>
                {{ $itinerary->location ?? '-' }}
            </li>
        </ul>
    </div>

@endsection