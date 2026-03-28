<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'tournament_id',
        'participant_a_id',
        'participant_b_id',
        'match_date',
        'location',
        'score_a',
        'score_b',
        'status',
        'referee_id',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
            'score_a' => 'integer',
            'score_b' => 'integer',
        ];
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participantA()
    {
        return $this->belongsTo(Participant::class, 'participant_a_id');
    }

    public function participantB()
    {
        return $this->belongsTo(Participant::class, 'participant_b_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }
}