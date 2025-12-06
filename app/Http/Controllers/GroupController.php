<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // View all groups
    public function index()
    {
        return Group::all();
    }

    // Create a new group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'destination' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return Group::create($validated);
    }

    // Show one group
    public function show($id)
    {
        return Group::findOrFail($id);
    }

    // Update a group
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $group->update($request->only(['name', 'destination', 'description']));

        return $group;
    }
    // Add a note to a group
public function addNote(Request $request, $id)
{
    $validated = $request->validate([
        'note' => 'required|string'
    ]);

    $group = Group::findOrFail($id);

    // Save note in the group (you must have a "note" column in DB)
    $group->note = $validated['note'];
    $group->save();

    return response()->json([
        'message' => 'Note added successfully',
        'group' => $group
    ]);
}


    // Delete a group
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }
}