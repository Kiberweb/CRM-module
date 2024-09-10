<?php

namespace Mod\Crm\Actions;

class DeleteScriptTagAction
{
    public static function handle(string $value): string
    {
        return preg_replace('/<script.*?>[\s\S]*?<\/script>/si', '', $value);
    }
}