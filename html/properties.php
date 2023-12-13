<?php
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Wenn der Benutzer nicht eingeloggt ist, leiten Sie ihn auf eine Login-Seite weiter.
    header("Location: login.php");
    exit;
}

// Verbindung zur Datenbank herstellen
$db = pg_connect("host=localhost dbname=muellmeister user=postgres password=admin");

if ($db) {
    // SQL-Abfrage, um den Wert der Spalte `verfuegbare_punkte` abzurufen
    $query = "SELECT verfuegbare_punkte FROM \"User\" WHERE username = $1";
    $result = pg_query_params($db, $query, array($_SESSION['username']));

    if ($result) {
        $row = pg_fetch_assoc($result);

        if ($row) {
            $verfuegbare_punkte = $row['verfuegbare_punkte'];
            // Hier haben Sie den Wert von `verfuegbare_punkte`

            // Schließen Sie das Ergebnis
            pg_free_result($result);
        }

    } else {
        echo "Fehler bei der Abfrage.";
    }

    // Schließen Sie die Verbindung zur Datenbank
    pg_close($db);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mülltrennung</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/properties.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="./index.html">Mülltrennung</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.html">Startseite</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./gamesquizzes.php">Games&Quizzes</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./trashlocations.html">Standorte von Mülltonnen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./properties.php">Grundstücke</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./profiles.php">Benutzerprofile</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./register.html">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./ueberuns.html">Über uns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.html">Kontakt</a>
                    </li>
                    <li class="nav-item">
                        <!-- Hier wird das Label angezeigt -->
                        <?php if (isset($verfuegbare_punkte)) : ?>
                            <label id="label_points"><?= $verfuegbare_punkte ?> Punkte verfügbar</label>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<h2>Grundstücke zum Verkauf</h2>
<table class="grasstexture">
    <tr>
        <td>
            <button class="buy-button" data-price="500" data-cell-id="1">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="750" data-cell-id="2">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="600" data-cell-id="3">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
    </tr>
    <tr>
        <td>
            <button class="buy-button" data-price="900" data-cell-id="4">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="550" data-cell-id="5">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="700" data-cell-id="6">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
    </tr>
    <tr>
        <td>
            <button class="buy-button" data-price="800" data-cell-id="7">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="650" data-cell-id="8">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
        <td>
            <button class="buy-button" data-price="720" data-cell-id="9">Kaufen</button>
            <label class="info-label" style="display: none;"></label>
        </td>
    </tr>
</table>
<button class="yes-button" style="display: none;">Ja</button>
<button class="no-button" style="display: none;">Nein</button>

<script src="../js/properties.js"></script>

<br><br><br><br><br>

<!-- Footer -->
<footer class="footer bg-dark text-white">
    <div class="container">
        <p>&copy; 2023 Müllmaster_Web</p>
    </div>
</footer>

<!-- Bootstrap JS (Popper.js and jQuery required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
