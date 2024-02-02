<?php

require_once('../classes/dbh.class.php');

//Functie die een nieuwe categorie aanmaakt
function createCategorie($pdo, $categorieName, $code) {
    $sql = "INSERT INTO Categorie (categorie, code) VALUES (:categorieName, :code)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

//Functie die de alle data uit database haalt 
function readCategories($pdo) {
    $sql = "SELECT * FROM Categorie";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Functie die een data ophaalt vanuit de database
function readCategorie($pdo, $id) {
    $sql = "SELECT * FROM Categorie WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Functie die de categorie update
function updateCategorie($pdo, $id, $categorieName, $code) {
    $sql = "UPDATE Categorie SET categorie = :categorieName, code = :code WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

//Functie die een categorie verwijderd
function deleteCategorie($pdo, $id) {
    $sql = "DELETE FROM Categorie WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}


