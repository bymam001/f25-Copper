<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class AIItineraryController extends Controller
{
    /**
     * Show the AI refinement form
     */
    public function showForm(Itinerary $itinerary)
    {
        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary,
            'response' => null, // VERY IMPORTANT
        ]);
    }

    /**
     * Handle AI refinement request
     */
    public function refine(Request $request, Itinerary $itinerary)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        $prompt = $request->prompt;

        // Fake AI response for now
        $aiResponse = "Here is an AI suggestion based on your request: '{$prompt}'.";

        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary,
            'response' => $aiResponse,  // VERY IMPORTANT
        ]);
    }
}