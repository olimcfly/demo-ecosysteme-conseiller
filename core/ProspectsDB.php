<?php
// ============================================================
// PROSPECTS DB — Connexion PDO séparée (base prospects)
// ============================================================

class ProspectsDB
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host    = $_ENV['PROSPECTS_DB_HOST'] ?? 'localhost';
            $port    = $_ENV['PROSPECTS_DB_PORT'] ?? '';
            $dbname  = $_ENV['PROSPECTS_DB_NAME'] ?? '';
            $user    = $_ENV['PROSPECTS_DB_USER'] ?? '';
            $pass    = $_ENV['PROSPECTS_DB_PASS'] ?? '';
            $charset = $_ENV['PROSPECTS_DB_CHARSET'] ?? 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            if ($port !== '') {
                $dsn .= ';port=' . (int) $port;
            }

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                ]);
            } catch (PDOException $e) {
                error_log('Prospects DB Connection failed: ' . $e->getMessage());
                http_response_code(500);
                die('Service temporairement indisponible.');
            }
        }

        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}
