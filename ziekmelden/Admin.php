<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneel - Ziekmeldingen</title>
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
        <h2>Beheren van ziekmeldingen docenten</h2>
        <nav>
            <ul>
                <li><h4><a href="Admin.php">Admin</a></h4></li>
                <li><h4><a href="index.php">Leerling versie</a></h4></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Admin Paneel</h2>
        <h4><a href="addziekmelding.php">Ziekmelding toevoegen</a></h4>

        <?php
        // Include de functie om ziekmeldingen te tonen
        include 'functies/ToonZiekAdmin.php';

        // Roep de functie aan om de ziekmeldingen weer te geven
        ToonZiekAdmin();
        ?>

        <p>Klik op het kruis om een record te verwijderen.</p>
    </main>
</body>
</html>
