<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
function sendMail($body, $name, $address)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.stuba.sk';                   // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $_POST['username'];                 // SMTP username
        $mail->Password = $_POST['password'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($_POST['username'] . '@stuba.sk', $name);
        $mail->addAddress($address);     // Add a recipient

        if (!empty($_FILES['attachment']['name'])) {
            $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
        }

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $_POST['subjectMail'];
        $mail->Body = $body;

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

function LDAPConnect($username, $password)
{
    $ldapconn = ldap_connect("ldap.stuba.sk")
    or die("Could not connect to LDAP server.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    $ldaprdn = "uid = " . $username . ", ou=People, DC=stuba, DC=sk";

    if ($ldapconn) {

        //Below line had several spelling mistakes
        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $password);

        if ($ldapbind) {
            $filter = "(uid=" . $username . ")";
            $result = ldap_search($ldapconn, "ou=People, DC=stuba, DC=sk", $filter);
            $info = ldap_get_entries($ldapconn, $result);
            return $info;
        }
    }
    return null;
}

?>