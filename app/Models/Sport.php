<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'win_points',
        'draw_points',
        'rules',
        'ranking_order',
        'result_unit',
    ];

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }
}