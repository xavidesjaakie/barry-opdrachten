<?php
// Include het databaseconnectiebestand
require_once "db_connect.php";

// Deze functie voegt een ziekmelding toe aan de database
function AddZiekmelding() {
    global $conn; // Gebruik de globale databaseverbinding

    // Controleer of het formulier is ingediend en de 'docent_naam' is ingesteld
    if (isset($_POST['docent_naam'])) {
        // Haal de ingevoerde gegevens op uit het formulier
        $Naam = $_POST['docent_naam']; // Naam van de docent
        $Datum = $_POST['Datum'];      // Datum van de ziekmelding

        try {
            // SQL-query om de ziekmelding toe te voegen aan de tabel 'ziekmelding'
            $sql = "INSERT INTO ziekmelding (docent_naam, Datum) VALUES ('$Naam', '$Datum')";

            // Voer de SQL-query uit
            $conn->exec($sql);

            // Redirect naar de homepage na succesvolle invoer
            header('Location: Admin.php');
        } catch (PDOException $e) {
            // Toon een foutmelding als er iets misgaat
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}
?>
