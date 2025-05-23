<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* @var $studens Student[]*/
/* @var $teams Team[] */
class School extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

}
