<?php

require_once "dbh.class.php";

class User extends Dbh {

    private $name;
    private $rol;
    private $email;
    private $password;

    public function __construct($name, $rol, $email) {
        $this->name = $name;
        $this->rol = $rol;
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function login($uname, $passw) {
        try {

            $db = $this->getConnection();

            
            $query = "SELECT wachtwoord FROM gebruiker WHERE gebruikersnaam = :uname";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':uname', $uname);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

       
            if ($result && password_verify($passw, $result['wachtwoord'])) {
                return true; // Login successful
            } else {
                return false; // Login failed
            }
        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
