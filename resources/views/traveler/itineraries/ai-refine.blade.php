@extends('layouts.traveler')

@section('content')
    <h1>AI Itinerary Refinement</h1>

    <p>You are refining itinerary:
        <strong>{{ $itinerary->name }}</strong>
    </p>

    <form action="{{ route('traveler.itineraries.ai-refine', $itinerary->id) }}" method="POST">
        @csrf

        <label>Describe what you want AI to change:</label><br>
        <textarea name="prompt" rows="4" class="form-control">{{ old('prompt') }}</textarea>

        <button class="btn btn-primary mt-3">Ask AI</button>
    </form>

    @if (!empty($response))
        <hr>
        <h3>AI Suggestion:</h3>
        <p>{{ $response }}</p>
    @endif
@endsection