<?php
// Dit bestand toont alle ziekmeldingen uit de database in een tabel.

// Include het databaseconnectiebestand
require_once('db_connect.php');

// Functie om alle ziekmeldingen te tonen
function ToonZiek() {
    global $conn; // Gebruik de globale databaseverbinding

    // SQL-query om alle ziekmeldingen op te halen
    $sql = "SELECT * FROM ziekmelding";

    try {
        // Voer de query uit en haal de resultaten op
        $result = $conn->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        // Toon de tabel met ziekmeldingen
        echo "<h2>Tabel ziekmelding docenten</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Docent</th><th>Reden en datum</th></tr>";

        // Controleer of er resultaten zijn
        if (count($result) > 0) {
            // Loop door de resultaten en toon elke rij
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['docent_naam']) . "</td>";
                echo "<td>" . htmlspecialchars($row['datum']) . "</td>";
                echo "</tr>";
            }
        } else {
            // Toon een bericht als er geen resultaten zijn
            echo "<tr><td colspan='2'>Geen ziekmeldingen gevonden.</td></tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        // Toon een foutmelding als er iets misgaat
        echo "Fout bij het ophalen van ziekmeldingen: " . $e->getMessage();
    }
}
?>
