<?php

declare(strict_types=1);


namespace App\Core\Database;

use App\Core\Utils\Redirect;
use App\Routes\Routes;
use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        try {
            $host = getenv('MYSQL_HOST');
            $database = getenv('MYSQL_DATABASE');

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
        unset($this->connection);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}