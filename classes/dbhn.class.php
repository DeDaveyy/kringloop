<?php

// Database configuratie
$servername = "localhost"; // De hostnaam van de database-server
$username = "root";        // Gebruikersnaam voor de database
$password = "";            // Wachtwoord voor de database-gebruiker
$database = "duurzaam";    // Naam van de database

try {
    // Probeert een PDO verbinding te maken
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Stel attributen in voor de PDO-verbinding om fouten te rapporteren als uitzonderingen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verbinding succesvol, je kunt dit bericht gebruiken voor debuggen
    // echo "Connection successful";
} catch (PDOException $e) { 
    // Geeft error message als er een fout is in de verbinding.
    echo "Connection failed" . $e->getMessage();
}
?>