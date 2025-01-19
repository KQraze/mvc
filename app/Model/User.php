<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'login', 'password', 'role_id'];
    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    public function getId(): int
    {
        return $this->id;
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'], 'password' => md5($credentials['password'])])->first();
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function employees()
    {
        return self::where('role_id', 2);
    }
}