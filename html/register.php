<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/php/pear/PHPMailer-master/src/Exception.php';
require 'C:/xampp/php/pear/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/php/pear/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Überprüfen, ob eine E-Mail-Adresse im richtigen Format eingegeben wurde
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ungültige E-Mail-Adresse.";
        exit;
    }

    // Verbindung zur Datenbank herstellen
    $db = pg_connect("host=localhost dbname=muellmeister user=postgres password=admin");

    if (!$db) {
        echo "Datenbankverbindung fehlgeschlagen.";
        exit;
    }

    // Überprüfen, ob die E-Mail-Adresse bereits in der Datenbank vorhanden ist
    $checkQuery = "SELECT * FROM \"User\" WHERE e_mail = $1";
    $checkResult = pg_query_params($db, $checkQuery, array($email));

    if (pg_num_rows($checkResult) > 0) {
        // E-Mail-Adresse ist bereits registriert
        header("Location: register_error.html");
        exit;
    }

    // SQL-Statement für die Registrierung
    $query = "INSERT INTO \"User\" (username, e_mail, passwort, gesammelte_punkte, verfuegbare_punkte) VALUES ($1, $2, $3, 0, 0);";
    $result = pg_query_params($db, $query, array($username, $email, $password));

    if ($result) {
        // Registrierung erfolgreich
        sendMail($email, 'Bestätigung über Registrierung bei Müllmaster_WEB!', 'Herzlichen Glückwunsch, Sie haben sich erfolgreich bei Müllmaster_WEB registriert! Viel Spaß!', $username, $email);
        header("Location: register_success.html");
    } else {
        // Registrierung fehlgeschlagen
        header("Location: register_error.html");
    }

    pg_close($db);
}

function sendMail($to, $subject, $message, $username, $email) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'edwards.i20@htlwienwest.at';                     // SMTP username
        $mail->Password   = 'HotelTangoLima15';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('edwards.i20@htlwienwest.at', 'Müllmaster_WEB');
        $mail->addAddress($to);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8'; // Set character set to UTF-8
        $mail->Subject = $subject;

        // HTML message
        $htmlMessage = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #3498db;
                    }
                    p {
                        color: #333;
                    }
                    .user-info {
                        margin-top: 20px;
                        padding: 10px;
                        background-color: #3498db;
                        color: #fff;
                        border-radius: 5px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>' . $subject . '</h2>
                    <p>' . $message . '</p>
                    <div class="user-info">
                        <p>Username: ' . $username . '</p>
                        <p>Email: ' . $email . '</p>
                    </div>
                </div>
            </body>
            </html>
        ';

        $mail->Body = $htmlMessage;

        $mail->send();
        echo 'Die E-Mail wurde erfolgreich versendet.';
    } catch (Exception $e) {
        echo "Fehler beim Versenden der E-Mail: {$mail->ErrorInfo}";
    }
}

?>
