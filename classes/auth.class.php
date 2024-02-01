<?php

session_start();

require_once 'dbh.class.php';

class Auth {

    private $dbh;

    public function __construct() {
        $this->dbh = (new Dbh())->getConnection();
    }

    public function login($username, $password) {
        $stmt = $this->dbh->prepare("SELECT * FROM gebruiker WHERE gebruikersnaam = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['wachtwoord'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['gebruikersnaam'];
            return true;
        } else {
            // Failed login
            return false;
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_unset();
        session_destroy();
    }
}