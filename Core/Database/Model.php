<?php

declare(strict_types=1);

namespace Core\Database;

class Model
{
    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function __destruct()
    {
        unset($this->database);
    }
}