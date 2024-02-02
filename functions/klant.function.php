<?php

require_once('../classes/dbh.class.php');


//Funcit die een nieuwe klant aanmaakt
function createKlant($pdo, $naam,$adres, $plaats, $telefoon, $email) {
    $sql = "INSERT INTO klant (naam, adres, plaats, telefoon, email) VALUES (:naam, :adres, :plaats, :telefoon, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':adres', $adres);
    $stmt->bindParam(':plaats', $plaats);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':email', $email);
    return $stmt->execute();
}

//Functie die alle data uit database halen

function readKlanten($pdo) {
    $sql = "SELECT * FROM klant";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// functie die een klant uit de datbase haalt
function readKlant($pdo, $id) {
    $sql = "SELECT * FROM klant WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


//functie die klant update
function updateKlant($pdo, $id, $naam, $adres, $plaats, $telefoon, $email) {
    $sql = "UPDATE klant SET naam = :naam, adres = :adres, plaats = :plaats, telefoon = :telefoon, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':adres', $adres);
    $stmt->bindParam(':plaats', $plaats);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':email', $email);
    return $stmt->execute();
}

//Functie die een klant verwijderd

function deleteKlant($pdo, $id) {
    $sql = "DELETE FROM klant WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

