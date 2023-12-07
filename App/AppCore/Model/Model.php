<?php

declare(strict_types=1);

namespace App\AppCore\Model;

use PDO;

class Model
{
    protected PDO|null $connection;

    public function __construct(PDO|null $connection)
    {
        $this->connection = $connection;
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}