<?php

class Config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=e_learning',
                    'root',
                    '',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                error_log("Database connection successful.");
            } catch (Exception $e) {
                error_log("Database connection failed: " . $e->getMessage());
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

