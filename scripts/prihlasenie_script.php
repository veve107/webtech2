<?php

if (isset($_POST["typ"])) {
    if ($_POST['typ'] == 1) {
        include_once "../config/config.php";
        $conn = mysqli_connect($servername, $usernameSQL, $passwordSQL, $db);
        $sql = "SELECT * FROM admin a WHERE a.username = '" . $_POST['usernameLog'] . "'";
        $result = $conn->query($sql);
        $preslo = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $passHash = password_hash($_POST['passwordLog'], PASSWORD_DEFAULT);
                if (password_verify($_POST['passwordLog'], $row['passHash'])) {
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['type'] = "admin";
                    header("Location: ../index.php");
                    $preslo = 1;
                }
                if ($preslo == 0) {
                    echo "<script>alert('Prihlasenie neuspesne, skontrolujte meno a heslo.');window.location.replace('../index.php');</script>";
                }
            }
        } else {
            $info = LDAPConnect();
            if ($info != null) {
                session_start();
                $_SESSION['id'] = $info[0]['uisid'][0];
                $_SESSION['name'] = $info[0]['cn'][0];
                $_SESSION['email'] = $info[0]['mail'][0];
                $_SESSION['type'] = "student";
                header("Location: ../index.php");
                $preslo = 1;
            }
            else{
                if ($preslo == 0) {
                    echo "<script>alert('Prihlasenie neuspesne, skontrolujte meno a heslo.');window.location.replace('index.php');</script>";
                }
            }
        }
    }
}

function LDAPConnect()
{
    $usernameLDAP = $_POST['usernameLog'];

    $ldapconn = ldap_connect("ldap.stuba.sk")
    or die("Could not connect to LDAP server.");

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    $ldaprdn = "uid = " . $usernameLDAP . ", ou=People, DC=stuba, DC=sk";
    $ldappass = $_POST['passwordLog'];

    if ($ldapconn) {

        //Below line had several spelling mistakes
        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

        if ($ldapbind) {
            $filter = "(uid=" . $usernameLDAP . ")";
            $result = ldap_search($ldapconn, "ou=People, DC=stuba, DC=sk", $filter);
            $info = ldap_get_entries($ldapconn, $result);
            return $info;
        }
    }
    return null;
}

?>