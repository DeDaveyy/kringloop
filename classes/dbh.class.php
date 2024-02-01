<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

    public function registerUser($username, $password) {
        // You can add additional parameters as needed for registration

        $pdo = $this->connect();

        // You should use prepared statements to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO gebruiker (gebruikersnaam, wachtwoord) VALUES (?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters and execute the query
        $stmt->execute([$username, $hashedPassword]);

        // You can add error handling and return a success/failure indicator as needed
        return true;
    }
}



