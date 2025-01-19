<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [];

    public function studentMarks(): HasMany
    {
        return $this->hasMany(StudentMark::class, 'student_id');
    }
}