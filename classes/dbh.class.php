<?php

class Dbh {

    //Properties van de database.
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "duurzaam";

    // Pakt de connectie
    public function getConnection() {
        return $this->connect();
    }

    // Maakt een connectie
    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

       // echo "Connectie gelukt";

        return $pdo;
    }

   
}



