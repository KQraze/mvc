<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['title', 'course', 'semester'];

    public function groupDisciplines(): HasMany
    {
        return $this->hasMany(GroupDiscipline::class, 'group_id');
    }

    public function groupStudents(): HasMany
    {
        return $this->hasMany(GroupStudent::class, 'group_id');
    }
}