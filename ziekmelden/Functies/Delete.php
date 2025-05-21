<?php
// Include het databaseconnectiebestand
require_once 'db_connect.php';

// Haal de naam van de docent op uit de URL (via GET-parameter)
$id = $_GET['id'];

try {
    // SQL-query om de ziekmelding te verwijderen op basis van de id
    $sql = "DELETE FROM ziekmelding WHERE id = :id";

    // Bereid de SQL-query voor
    $stmt = $conn->prepare($sql);

    // Bind de parameter aan de query
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    // Voer de query uit
    $stmt->execute();

         header('Location: ../index.php');

} catch (PDOException $e) {
    // Toon een foutmelding als er iets misgaat
    echo "Fout bij het verwijderen: " . $e->getMessage();
}

// Sluit de databaseverbinding
$conn = null;
?>
