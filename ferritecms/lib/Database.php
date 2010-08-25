<?php

/**
 * FerriteCMS singleton database class
 * Uses an SQLite database, via PDO.
 */
class Database
{
    // Stores the instance of the database connection
    private static $dbInstance;
    
    /**
     * Returns only one instance of the database connection
     * @return PDO Instance of the PDO object
     */
    public static function getInstance() {
        if (!self::$dbInstance) {
            try {
                $dsn = 'sqlite:' . CMS_ROOT . 'database.db';
                self::$dbInstance = new PDO($dsn);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        
        return self::$dbInstance;
    }
}
