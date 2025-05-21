<?php
// Dit bestand toont een formulier om een nieuwe ziekmelding toe te voegen
// en roept de functie aan om deze in de database op te slaan.

// Include het bestand met de functie om een ziekmelding toe te voegen
include 'functies/add.php';

// Roep de functie aan om een ziekmelding toe te voegen als het formulier is ingediend
AddZiekmelding();
?>

<!-- Formulier om een nieuwe ziekmelding toe te voegen -->
<form action="" method="post">
    <p>
        <!-- Invoerveld voor de naam van de docent -->
        <input type="text" placeholder="docent_naam" name="docent_naam" id="docent_naam" required>
        <br>

        <!-- Invoerveld voor de datum van de ziekmelding -->
        <input type="text" placeholder="Datum" name="Datum" id="Datum" required>
        <br>

        <!-- Knop om het formulier in te dienen -->
        <input type="submit" value="Toevoegen">
    </p>
</form>
