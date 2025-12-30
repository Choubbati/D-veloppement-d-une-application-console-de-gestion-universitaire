<?php

require_once __DIR__ . '/../database/Connextion.php';

class LoginService
{

    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkData($email)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    
}