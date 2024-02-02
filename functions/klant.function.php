<?php

require_once('../classes/dbh.class.php');

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

function readKlanten($pdo) {
    $sql = "SELECT * FROM klant";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function readKlant($pdo, $id) {
    $sql = "SELECT * FROM klant WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

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

function deleteKlant($pdo, $id) {
    $sql = "DELETE FROM klant WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

