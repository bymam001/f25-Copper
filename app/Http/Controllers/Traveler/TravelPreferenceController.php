<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\TravelPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelPreferenceController extends Controller
{
    // Show the form
    public function edit()
    {
        $user = Auth::user();

        // Try to load existing preferences
        $preference = $user->travelPreference;

        // If none exist, create an empty object for the form
        if (!$preference) {
            $preference = new TravelPreference();
        }

        return view('traveler.travel-preferences.my-edit', [
            'preference' => $preference
        ]);
    }

    // Save the form
    public function update(Request $request)
    {
        $user = Auth::user();

        // Find or create preferences for this user
        $preference = $user->travelPreference;
        if (!$preference) {
            $preference = new TravelPreference();
            $preference->user_id = $user->id;
        }

        // Assign simple values
        $preference->travel_style = $request->input('travel_style');
        $preference->budget_level = $request->input('budget_level');
        $preference->preferred_activities = $request->input('preferred_activities');
        $preference->preferred_countries = $request->input('preferred_countries');
        $preference->notes = $request->input('notes');

        $preference->save();

        return redirect()
            ->route('traveler.travel_preferences.edit')
            ->with('status', 'Preferences saved');
    }
}