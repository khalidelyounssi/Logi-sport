<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'status',
        'sport_id',
        'organizer_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function matches()
    {
        return $this->hasMany(MatchModel::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}