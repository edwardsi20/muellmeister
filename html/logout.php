<?php
session_start();

// Sitzungsvariablen löschen
unset($_SESSION['logged_in']);
unset($_SESSION['username']);

// Sitzung beenden
session_destroy();

// Weiterleitung auf die Login-Seite
header("Location: login.php");
exit;
?>
