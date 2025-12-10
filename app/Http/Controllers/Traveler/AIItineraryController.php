<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use OpenAI\Laravel\Facades\OpenAI;
use App\Services\OpenAIService;

class AIItineraryController extends Controller
{
    protected OpenAIService $ai;

    public function __construct(OpenAIService $ai)
    {
        $this->ai = $ai;
    }

    public function showForm(Itinerary $itinerary)
    {
        $this->authorize('update', $itinerary);

        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary,
            'response'  => null,
        ]);
    }

    public function refine(Request $request, Itinerary $itinerary)
    {
        $this->authorize('update', $itinerary);

        $data = $request->validate([
            'prompt' => ['required', 'string', 'max:1000'],
        ]);

        $summary       = 'No response from AI.';
        $changedFields = [];

        try {
            // Build one big prompt that tells AI to return ONLY JSON
            $prompt = <<<EOT
You help users tweak travel itineraries.

Given the current itinerary and a user request, respond ONLY with valid JSON.

The JSON must have:
  "summary" (string) and
  "updates" (object with any of: name, description, destination, location, start_date, end_date).

Dates should be YYYY-MM-DD. No extra text outside the JSON.

Here is the data:

EOT;

            $prompt .= json_encode([
                'itinerary' => $itinerary->toArray(),
                'request'   => $data['prompt'],
            ]);

            // Call our OpenAIService
            $raw = $this->ai->ask($prompt) ?? '';

            $decoded = json_decode($raw, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $summary      = $decoded['summary'] ?? $summary;
                $updatesInput = $decoded['updates'] ?? [];

                $allowed = ['name', 'description', 'destination', 'location', 'start_date', 'end_date'];
                $updates = [];

                foreach ($allowed as $field) {
                    if (!array_key_exists($field, $updatesInput) ||
                        $updatesInput[$field] === null ||
                        $updatesInput[$field] === '') {
                        continue;
                    }

                    if (in_array($field, ['start_date', 'end_date'], true)) {
                        try {
                            $updates[$field] = Carbon::parse($updatesInput[$field])->format('Y-m-d');
                        } catch (\Throwable $e) {
                            // ignore bad dates
                        }
                    } else {
                        $updates[$field] = $updatesInput[$field];
                    }
                }

                if (!empty($updates)) {
                    $itinerary->update($updates);
                    $itinerary->refresh();
                    $changedFields = array_keys($updates);
                }
            } else {
                $summary = 'Could not parse AI response.';
            }
        } catch (\Throwable $e) {
            $summary = 'AI service error: ' . $e->getMessage();
        }

        if (!empty($changedFields)) {
            $summary .= ' (Updated fields: ' . implode(', ', $changedFields) . '.)';
        }

        return view('traveler.itineraries.ai-refine', [
            'itinerary' => $itinerary,
            'response'  => $summary,
        ]);
    }
}