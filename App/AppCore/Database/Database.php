<?php

declare(strict_types=1);


namespace App\AppCore\Database;

use App\AppCore\Utils\Redirect;
use App\Routes\Routes;
use PDO;
use PDOException;

class Database
{
    private PDO|null $connection;

    public function __construct()
    {
        $host = getenv('MYSQL_HOST');
        $database = getenv('MYSQL_DATABASE');

        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$database;charset=utf8mb4",
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            Redirect::redirect(Routes::AppError, []);
        }
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function getConnection(): PDO
    {
        if (!$this->connection) {
            Redirect::redirect(Routes::AppError, []);
        }

        return $this->connection;
    }
}