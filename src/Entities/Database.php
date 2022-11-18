<?php

class Database
{
    use SingletonTrait;

    private PDO $database;

    private function __construct()
    {
        try {
            $this->database = new PDO(
                sprintf('mysql:host=%s;dbname=%s;port=%s', 'db_todo_pdo_server', 'todo', 3306),"root","root");
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $exception) {
            die('Erreur : '.$exception->getMessage());
        }
    }

    public static function get(): PDO
    {
        return self::getInstance()->database;
    }
}