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
        'name',
        'color'
    ];
    public function getTotalScore()
    {
        $score = 0;
        foreach ($this->participants as $participant) {
            $score += $participant->score;
        }
        return $score;
    }
    public function defence()
    {
        return $this->belongsTo(Defence::class);
    }

    public function participants()
    {
        return $this->hasMany(DefenceParticipant::class, 'act_defence_id');
    }
}
