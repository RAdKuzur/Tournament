<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenceParticipant extends Model
{
    use HasFactory;

    protected $table = 'defence_participant';

    protected $fillable = [
        'act_defence_id',
        'score',
        'student_id'
    ];

    public function actDefence()
    {
        return $this->belongsTo(ActDefence::class, 'act_defence_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'defence_participant_id');
    }
}
