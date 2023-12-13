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
    <link rel="stylesheet" href="../css/profiles.css">
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

<h2>Benutzerprofile</h2>
<?php
$connection = pg_connect("host=localhost dbname=muellmeister user=postgres password=admin");
if (!$connection) {
    echo "An error occurred. <br>";
    exit;
}
$result = pg_query($connection, "select username, gesammelte_punkte, verfuegbare_punkte from \"User\" u order by gesammelte_punkte desc;");
if (!$result) {
    echo "An error occurred. <br>";
    exit;
}
?>

<table>
    <tr>
        <th>Username</th>
        <th>Punkte gesamt</th>
        <th>Verfügbare Punkte</th>
    </tr>

    <?php
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>$row[username]</td>";
        echo "<td>$row[gesammelte_punkte]</td>";
        echo "<td>$row[verfuegbare_punkte]</td>";
        echo "</tr>";
    }
    ?>
</table>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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
