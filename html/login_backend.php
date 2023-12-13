<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/php/pear/PHPMailer-master/src/Exception.php';
require 'C:/xampp/php/pear/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/php/pear/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verbindung zur Datenbank herstellen
    $db = pg_connect("host=localhost dbname=muellmeister user=postgres password=admin");

    if (!$db) {
        echo "Datenbankverbindung fehlgeschlagen.";
        exit;
    }

    $query = "SELECT * FROM \"User\" WHERE Username = $1 AND Passwort = $2";
    $result = pg_query_params($db, $query, array($username, $password));

    if ($result) {
        $row = pg_fetch_assoc($result);

        if ($row) {
            // Anmeldung erfolgreich

            // Sende E-Mail
            sendMail($row['e_mail'], 'Anmeldung bei Müllmaster_WEB', $username, $row['e_mail']);

            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username; // Speichert den Benutzernamen in der Session
            header("Location: login_success.html"); // Weiterleitung zur Erfolgsmeldung
        } else {
            // Anmeldung fehlgeschlagen
            header("Location: login_error.html"); // Weiterleitung zur Fehlermeldung
        }

        pg_free_result($result);
    }

    pg_close($db);
}

function sendMail($to, $subject, $username, $email) {
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
                    <p>Sie haben sich erfolgreich angemeldet.</p>

                    <div class="user-info">
                    <p>Wenn Sie das nicht waren, kontaktieren Sie bitte den Eigentümer <br> der Website unter  <a href="https://t.me/edw_Rothenburg">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/512px-Telegram_logo.svg.png" alt="Telegram Logo" style="width: 17px; height: 17px; margin-right: 5px;">
                    edw_Rothenburg
                </a>
                
                    </p>
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
