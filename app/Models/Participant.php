<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'contact_person',
        'status',
        'tournament_id',
        'user_id'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(MatchModel::class, 'participant_a_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(MatchModel::class, 'participant_b_id');
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}       