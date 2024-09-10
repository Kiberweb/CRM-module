<?php
declare(strict_types=1);

namespace Mod\Crm\Actions;

use RedBeanPHP\R;

class MakeUserTableAction
{
    public static function handler(): bool
    {
        $result = R::getCell("SHOW TABLES LIKE ?", ['users']);

        if (!$result) {
            R::exec('
                CREATE TABLE users (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    username VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    message TEXT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                )
            ');
            return false;
        }

        return true;
    }
}