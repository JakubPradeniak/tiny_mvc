<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Database;
use PDO;

class Controller
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = (new Database())->getConnection();
    }

    public function __destruct()
    {
        unset($this->connection);
    }
}