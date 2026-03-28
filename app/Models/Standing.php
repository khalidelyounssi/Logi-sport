<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'participant_id',
        'points',
        'played',
        'won',
        'lost',
        'draw',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'played' => 'integer',
            'won' => 'integer',
            'lost' => 'integer',
            'draw' => 'integer',
        ];
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}