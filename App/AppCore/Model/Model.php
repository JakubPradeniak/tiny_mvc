<?php

declare(strict_types=1);

namespace App\AppCore\Model;

use PDO;

class Model
{
    public function __construct(protected PDO $connection)
    {
    }

    public function __destruct()
    {
        unset($this->connection);
    }
}