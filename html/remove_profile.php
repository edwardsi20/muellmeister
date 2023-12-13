<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Verbindung zur Datenbank herstellen
    $db = pg_connect("host=localhost dbname=muellmeister user=postgres password=admin");

    if (!$db) {
        header("Location: delete_error.html"); // Datenbankverbindung fehlgeschlagen
        exit;
    }

    // Den aktuellen Benutzernamen aus der Session abrufen
    $username = $_SESSION['username'];

    // SQL-Statement zum Löschen des Benutzerprofils
    $query = "DELETE FROM \"User\" WHERE Username = $1";
    $result = pg_query_params($db, $query, array($username));

    if ($result) {
        // Löschen war erfolgreich
        session_destroy();
        header("Location: delete_success.html");
    } else {
        // Löschen ist fehlgeschlagen
        header("Location: delete_error.html");
    }

    // Datenbankverbindung schließen
    pg_close($db);
} else {
    // Benutzer ist nicht angemeldet
    header("Location: delete_error.html");
}
?>
