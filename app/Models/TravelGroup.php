<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelGroup extends Model
{
    use HasFactory;

    // Which columns are safe to fill from a form
    protected $fillable = [
        'name',
        'creator_id',
    ];
    // The user who created this travel group
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
}
// Invitations for this travel group
public function invitations()
{
    return $this->hasMany(\App\Models\TravelGroupInvitation::class, 'travel_group_id');

}
}