<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActDefence extends Model
{
    use HasFactory;

    protected $table = 'act_defence';

    protected $fillable = [
        'defence_id',
        'type',
        'name'
    ];

    public function defence()
    {
        return $this->belongsTo(Defence::class);
    }

    public function participants()
    {
        return $this->hasMany(DefenceParticipant::class, 'act_defence_id');
    }
}
