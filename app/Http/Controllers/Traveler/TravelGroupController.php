<?php

namespace App\Http\Controllers\Traveler;
use App\Http\Controllers\Controller;
use App\Models\TravelGroup;
use App\Models\TravelGroupInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TravelGroupController extends Controller
{
    // Show the list of groups the logged-in user has created
    public function index()
    {
        $groups = Auth::user()->travelGroupsCreated;
        return view('traveler.travel-groups.my-index', compact('groups')); 
            
}
// Show the form submit to create a group
public function create()
{
    return view('traveler.travel-groups.my-create');
}
// Handle the form submit to create a group
public function store(Request $request)
{
    // basic validation
    $request->validate([
        'name' => 'required|string|max:255',
    ]);
     // save the group
     TravelGroup::create([
        'name' => $request->name,
        'creator_id' => Auth::id(),
    ]);

    return redirect()
        ->route('traveler.travel_groups.index')
        ->with('status', 'Group created successfully!');
}
    // Show a single group
    public function show(TravelGroup $group)
    {
        // eager load invitations so $group->invitations works
        $group->load('invitations');
    return view('traveler.travel-groups.my-show', compact('group'));
    }
    // Handle sending an invitation to a group
    public function invite(Request $request, TravelGroup $group)

    {
        // TEMP: if still fails, uncomment this ilne to see exactly
        //dd($request->all());
    
        // Validate email input
        $validated = $request->validate([
            'email' => ['required' , 'email' , 'max:255'],
        ]);
        // Create the invitation
        TravelGroupInvitation::create([
            'travel_group_id' => $group->id,
            'email' => $validated['email'],
            'invited_by' => Auth::id(),
            'status' => 'pending',
        ]);
        return redirect()
            ->route('traveler.travel_groups.show', $group)
            ->with('status', 'Invitation sent successfully!');
}
}

