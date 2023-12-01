<?php
class Database {
    private $host;
    private $user;
    private $password;
    private $dbname;    

    public function __construct() {
        // Utilise les variables d'environnement définies dans phpunit.xml
        $this->host = getenv('DB_HOST');
        $this->user = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->dbname = getenv('DB_DATABASE');
    }

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
        }
    }
}
