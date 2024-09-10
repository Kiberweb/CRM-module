<?php

namespace Mod\Crm\Actions;

class HashPassAction
{
    public static function handler(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}