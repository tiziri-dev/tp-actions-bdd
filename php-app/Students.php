<?php

class Students {
    private $pdo;

    public function __construct() {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $db   = getenv('DB_NAME') ?: 'tp';
        $user = getenv('DB_USER') ?: 'postgres';
        $pass = getenv('DB_PASSWORD') ?: 'postgres';
        
        $this->pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    }

    public function addStudent($name, $grade) {
        $stmt = $this->pdo->prepare("INSERT INTO students (name, grade) VALUES (?, ?)");
        $stmt->execute([$name, $grade]);
    }

    public function getStudent($name) {
        $stmt = $this->pdo->prepare("SELECT name, grade FROM students WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function averageGrade() {
        $stmt = $this->pdo->query("SELECT AVG(grade) FROM students");
        $result = $stmt->fetchColumn();
        return $result !== false ? (float)$result : null;
    }
}