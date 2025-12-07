<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIItineraryController extends Controller
{
    /**
     * Show the AI refinement form
     */
    public function showForm(Itinerary $itinerary)
    {
        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary,
            'response' => null,
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

        /*
        |--------------------------------------------------------------------------
        | 1. SEND MESSAGE TO OPENAI
        |--------------------------------------------------------------------------
        */
        $response = Http::withToken(env('OPENAI_API_KEY'))->post(
            'https://api.openai.com/v1/chat/completions',
            [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an itinerary editing assistant. ALWAYS reply in JSON. 
                        
                        Valid actions:
                        - update_time
                        - add_activity
                        - remove_activity

                        Example:
                        {\"action\": \"update_time\", \"item\": \"Museum\", \"new_time\": \"16:00\"}"
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. PARSE AI RESPONSE
        |--------------------------------------------------------------------------
        */
        $content = $response->json()['choices'][0]['message']['content'] ?? '{}';
        $ai = json_decode($content, true);

        if (!is_array($ai)) {
            $ai = ["error" => "AI did not produce valid JSON"];
        }

        /*
        |--------------------------------------------------------------------------
        | 3. UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        if (isset($ai['action'])) {

            // Example: Update itinerary start time
            if ($ai['action'] === 'update_time') {
                $itinerary->update([
                    'start_time' => $ai['new_time'] ?? $itinerary->start_time
                ]);
            }

            // Add a new itinerary item
            if ($ai['action'] === 'add_activity' && $itinerary->relationLoaded('items')) {
                $itinerary->items()->create([
                    'title' => $ai['item'] ?? 'New Activity',
                    'time' => $ai['new_time'] ?? '00:00',
                ]);
            }

            // Remove an itinerary item
            if ($ai['action'] === 'remove_activity' && $itinerary->relationLoaded('items')) {
                $itinerary->items()
                    ->where('title', $ai['item'])
                    ->delete();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. RETURN VIEW WITH UPDATED DATA
        |--------------------------------------------------------------------------
        */

        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary->fresh(),
            'response' => $ai,
        ]);
    }
}
