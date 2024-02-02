<?php

require_once('../classes/dbh.class.php');


function createCategorie($pdo, $categorieName, $code) {
    $sql = "INSERT INTO Categorie (categorie, code) VALUES (:categorieName, :code)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

function readCategories($pdo) {
    $sql = "SELECT * FROM Categorie";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function readCategorie($pdo, $id) {
    $sql = "SELECT * FROM Categorie WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCategorie($pdo, $id, $categorieName, $code) {
    $sql = "UPDATE Categorie SET categorie = :categorieName, code = :code WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

function deleteCategorie($pdo, $id) {
    $sql = "DELETE FROM Categorie WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

?>
