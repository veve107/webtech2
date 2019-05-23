<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Prihlásenie</title>
</head>
<body>

<div id="logreg-forms">
    <form class="form-signin" method="post" action="scripts/prihlasenie_script.php">
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Prihláste sa</h1>
        <input type="text" id="inputUsername" class="form-control" name="usernameLog" placeholder="Používateľské meno"
               required="required">
        <input type="password" id="inputPassword" class="form-control" name="passwordLog" placeholder="Heslo"
               required="required">

        <button class="btn btn-success btn-block" type="submit" name="typ" value="1"><i class="fas fa-sign-in-alt"></i>
            Prihlásiť sa
        </button>
    </form>
    <br>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="scripts/script.js"></script>
</body>
</html>