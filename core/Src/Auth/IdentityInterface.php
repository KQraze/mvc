<?php

namespace Src\Auth;

interface IdentityInterface
{
    public function findIdentity(int $id);

    public function getId(): int;

    public function getRoleId(): int;

    public function attemptIdentity(array $credentials);

    public function employees();
}