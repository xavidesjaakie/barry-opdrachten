<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website voor ziekmelding docenten (Leerling versie)</title>
    <!-- Dit bestand toont een overzicht van ziekmeldingen voor leerlingen
         en biedt een link naar het adminpaneel -->
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h2>Website voor ziekmelding docenten (Leerling versie)</h2>
        <nav>
            <ul>
                <li><h4><a href="Admin.php">Admin</a></h4></li>
                <li><h4>Leerling</h4></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        // Include de functie om ziekmeldingen te tonen
        include 'functies/ToonZiek.php';

        // Roep de functie aan om de ziekmeldingen weer te geven
        ToonZiek();
        ?>
    </main>
</body>
</html>
