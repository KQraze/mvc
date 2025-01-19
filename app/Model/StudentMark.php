<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentMark extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = null; // Указывает, что первичного ключа как такового нет.
    public $incrementing = false; // Запрещает автоинкремент.

    public $fillable = ['student_id', 'mark_id', 'discipline_id'];

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
    public function mark(): BelongsTo
    {
        return $this->belongsTo(Mark::class, 'mark_id');
    }
}