<?php
// Databaseconfiguratie
$servername = "localhost"; // Servernaam (meestal localhost)
$username = "root";        // Gebruikersnaam voor de database
$password = "";            // Wachtwoord voor de database
$dbname = "case1";         // Naam van de database

try {
    // Maak een nieuwe PDO-verbinding
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Stel de foutmodus in op uitzondering (exception)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Toon een foutmelding als de verbinding mislukt
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
