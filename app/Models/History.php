<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'defence_participant_id',
        'type',
        'score'
    ];

    public function participant()
    {
        return $this->belongsTo(DefenceParticipant::class, 'defence_participant_id');
    }
}
