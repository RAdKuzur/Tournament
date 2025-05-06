<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* @var $games Game[] */
class Tournament extends Model
{
    public const INIT_TOUR = 0;
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'begin_date',
        'finish_date',
        'current_tour'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
