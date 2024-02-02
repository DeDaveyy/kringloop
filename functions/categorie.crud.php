<?php

require_once('../classes/dbh.class.php');

$db = new Dbh();
$db->getConnection();

function createCategorie($db, $categorieName, $code) {
    $sql = "INSERT INTO Categorie (categorie, code) VALUES (:categorieName, :code)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

function readCategories($db) {
    $sql = "SELECT * FROM Categorie";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function readCategorie($db, $id) {
    $sql = "SELECT * FROM Categorie WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCategorie($db, $id, $categorieName, $code) {
    $sql = "UPDATE Categorie SET categorie = :categorieName, code = :code WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':categorieName', $categorieName);
    $stmt->bindParam(':code', $code);
    return $stmt->execute();
}

function deleteCategorie($db, $id) {
    $sql = "DELETE FROM Categorie WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

?>
