<?php

require_once('../classes/dbh.class.php');

function createArtikel($pdo, $categorie_id, $naam, $prijs_ex_btw) {
    $sql = "INSERT INTO Artikel (categorie_id, naam, prijs_ex_btw) VALUES (:categorie_id, :naam, :prijs_ex_btw)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categorie_id', $categorie_id);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':prijs_ex_btw', $prijs_ex_btw);
    return $stmt->execute();
}

function readArtikels($pdo) {
    $sql = "SELECT `artikel`.id as artikel_id, 
                   `artikel`.`naam`, 
                   `artikel`.`prijs_ex_btw`,
                   `categorie`.`id` as categorie_id,
                   `categorie`.`categorie`
            FROM `artikel` 
            JOIN `categorie` ON `artikel`.`categorie_id` = `categorie`.`id`";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function readArtikel($pdo, $id) {
    $sql = "SELECT A.*, C.categorie, C.code FROM Artikel A
            LEFT JOIN Categorie C ON A.categorie_id = C.id
            WHERE A.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateArtikel($pdo, $id, $categorie_id, $naam, $prijs_ex_btw) {
    $sql = "UPDATE Artikel SET categorie_id = :categorie_id, naam = :naam, prijs_ex_btw = :prijs_ex_btw WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':categorie_id', $categorie_id);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':prijs_ex_btw', $prijs_ex_btw);
    return $stmt->execute();
}

function deleteArtikel($pdo, $id) {
    $sql = "DELETE FROM Artikel WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>
