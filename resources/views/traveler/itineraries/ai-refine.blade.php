@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">AI Itinerary Refinement</h1>

<form method="POST" action="{{ route('traveler.itineraries.ai-refine', $itinerary->id) }}">
    @csrf

    <textarea 
        name="prompt" 
        rows="4" 
        class="w-full border p-3 rounded" 
        placeholder="Tell AI how you want to modify your itinerary"
    ></textarea>

    <button 
        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
    >
        Send to AI
    </button>
</form>

@if($response)
    <div class="mt-6">
        <h2 class="font-semibold text-xl">AI Response</h2>
        <pre class="bg-gray-100 p-3 rounded mt-2">{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
    </div>
@endif

<div class="mt-6">
    <h2 class="font-semibold text-xl">Updated Itinerary (from database)</h2>
    <pre class="bg-gray-100 p-3 rounded mt-2">{{ $itinerary->toJson(JSON_PRETTY_PRINT) }}</pre>
</div>

@endsection
