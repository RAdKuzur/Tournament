<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defence extends Model
{
    use HasFactory;

    protected $table = 'defence';

    protected $fillable = [
        'name'
    ];

    public function actDefences()
    {
        return $this->hasMany(ActDefence::class, 'defence_id');
    }
}
