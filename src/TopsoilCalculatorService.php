<?php

namespace Kev\FreetimersCandidateTest;

use PDO;

class TopsoilCalculatorService
{
    private PDO $pdo;

    /**
     * This should be injected or got form a DI container but for brevity I'm leaving it here
     */
    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $db   = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $options);


    }

    public function createCalculationsTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS calculations (bags INT(11))";
        $this->pdo->exec($query);
    }

    public function insertCalculatedBags(int $bags): bool
    {
        $query = "INSERT INTO calculations (`bags`) VALUES (:bags)";
        $statement = $this->pdo->prepare($query);
        return $statement->execute(['bags' => $bags]);
    }


}