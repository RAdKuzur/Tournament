<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamStudent extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'team_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function participants()
    {
        return $this->hasMany(TeamStudentParticipant::class);
    }
}
