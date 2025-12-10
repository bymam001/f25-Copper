<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelGroupInvitation extends Model
{
    // Allow mass-assignment for these columns
    protected $fillable = [
        'travel_group_id',
        'email',
        'invited_by',
        'status',
    ];
    // The travel group this invitation belongs to
    public function group()
    {
        return $this->belongsTo(TravelGroup::class, 'travel_group_id');
    }
    // The user who sent the invitation(optional)
    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
}
}