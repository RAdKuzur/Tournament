<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'begin_date',
        'finish_date'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
