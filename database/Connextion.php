<?php 

class Connextion{
    private string $host;
    private string $dbname;
    private string $charset;
    private string $root;
    private string $password;

    private ?PDO $pdo = null;

    public function __construct(){
        $this->host = 'localhost';
        $this->dbname = 'gestion_universitaire';
        $this->charset = 'utf8';
        $this->root = 'root';
        $this->password = '';
    }

    public function getConnextion(): PDO{
        if($this->pdo === null){
            try {
                $dns = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
                $this->pdo = new PDO($dns, $this->root, $this->password);
                echo 'success';
            } catch (PDOException $e) {
                die('Erreur dans database' . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
?>
