<?php
declare(strict_types=1);

namespace Mod\Crm\Actions;

use RedBeanPHP\R;

class TestConnectionDBAction
{
    public static function handler(): string
    {
        return (R::testConnection()) ? 'Connection successful!' : 'Connection failed.';
    }
}