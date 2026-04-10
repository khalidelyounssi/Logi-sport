<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class, 'organizer_id');
    }

    public function assignedMatches()
    {
        return $this->hasMany(MatchModel::class, 'referee_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function participations()
{
    return $this->hasMany(Participant::class);
}
}