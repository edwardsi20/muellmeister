<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Wenn der Benutzer nicht eingeloggt ist, leiten Sie ihn auf eine Login-Seite weiter.
    header("Location: login.php");
    exit;
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
                </ul>
            </div>
        </div>
    </nav>

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
