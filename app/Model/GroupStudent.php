<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupStudent extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}