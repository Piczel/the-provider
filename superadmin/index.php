<?php
    session_start();
    if(isset($_SESSION['superadmin'])) {
        header('Location: admin.php');
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Superadmin</title>
</head>
<body>
    <h2>Logga in som superadministratör</h2>
    <form action="php/sign-in-superadmin.php" method="post">
        <div>Användarnamn</div>
        <input type="text" name="username">
        <div>Lösenord</div>
        <input type="password" name="password">
        <br><br>
        <input type="submit" value="Logga in">
    </form>

    <?php 
        if(isset($_SESSION['signInMessage']))
        {
            echo '<h3>'.$_SESSION['signInMessage'].'</h3>';
            unset($_SESSION['signInMessage']);
        }
    ?>
    
</body>
</html>