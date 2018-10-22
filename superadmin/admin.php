<?php
    include '../utility/utility.php';

    session_start();
    if(!isset($_SESSION['superadmin'])) {
        header('Location: index.php');
        exit;
    }


    if(isset($_GET['register-account'])) {

        try {
            Input::validate($_POST, [
                'email' => 100,
                'username' => 50,
                'password' => null
            ]);

            if(!($register_accountID = Account::register(
                $_POST['email'],
                $_POST['username'],
                $_POST['password'],
                'admin'
            ))) {
                throw new Exception('Kunde inte slutföra registrering. Detta kan bero på att användarnamnet måste vara unikt');
            }

        } catch(Exception $exc)
        {
            $error_register = $exc->getMessage();
        }

        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="php/sign-out-superadmin.php">Logga ut</a>
    <h2>Registrera kund</h2>
    <div>
        <?php
        if(!isset($_GET['register-account']))
        {
            # Form not submitted

            echo '
        <form action="admin.php?register-account=1" method="post">
            <div>Användarnamn</div>
            <input type="text" name="username">
            <div>Lösenord</div>
            <input type="password" name="password">
            <div>E-post</div>
            <input type="email" name="email">
            <br><br>
            <input type="submit" value="Registrera">
        </form>';

        } else 
        {
            # Form submitted

            if(isset($error_register))
            {
                # Error with form

                echo '
        <form action="admin.php?register-account=1" method="post">
            <div>Användarnamn</div>
            <input type="text" name="username" value="'. $_POST['username'] .'">
            <div>Lösenord</div>
            <input type="password" name="password" value="'. $_POST['password'] .'">
            <div>E-post</div>
            <input type="email" name="email" value="'. $_POST['email'] .'">
            <br><br>
            <input type="submit" value="Registrera">
        </div>
        <h3>FEL: '. $error_register .'</h3>
        <a href="admin.php"><- Återställ</a>';

            } else
            {
                # Account registered

                echo '
        <div>
            <div>Användarnamn</div>
            <div><b>'. $_POST['username'] .'</b></div>
            <div>Lösenord</div>
            <div><b>'. $_POST['password'] .'</b></div>
            <div>E-post</div>
            <div><b>'. $_POST['email'].'</b></div>
            <div>KontoID</div>
            <div><b>'. $register_accountID .'</b></div>
        </div>
        <h3>Användaren lades till</h3>
        <a href="admin.php"><- Återställ</a>';
            }
        }
        ?>
    </div>

        <br><br><br>
    <div>
        <h2>Hantera konton och tjänster</h2>
        <?php 
            if(isset($_SESSION['activationMessage']))
            {
                echo '<h3>'.$_SESSION['activationMessage'].'</h3>';
                unset($_SESSION['activationMessage']);
            }
        ?>
        <table cellspacing="0" cellpadding="4" border="1px solid black">
            <tr>
                <th>KontoID</th>
                <th>Användarnamn</th>
                <th>E-post</th>
                <th> </th>
                <th>Blogg</th>
                <th>Kalender</th>
                <th>Spel</th>
                <th>Wiki</th>
            </tr>

            <?php

                $connection = new DBConnection();

                $statuses = $connection->query(
                    'SELECT
                        accountID,
                        username,
                        email,
                        b.activated_tp AS "blog",
                        c.activated_tp AS "calendar",
                        g.activated_tp AS "game",
                        w.activated_tp AS "wiki"
                    FROM account 
                        LEFT JOIN admin_blog AS b
                            ON b.forAccountID = accountID
                        LEFT JOIN admin_calendar AS c
                            ON c.forAccountID = accountID
                        LEFT JOIN admin_game AS g
                            ON g.forAccountID = accountID
                        LEFT JOIN admin_wiki AS w
                            ON w.forAccountID = accountID
                    WHERE account.`type` = "admin"
                    ORDER BY accountID ASC');

                foreach($statuses as $row)
                {   
                    echo '<tr><form>';
                    echo '<td>'. $row['accountID'] .'</td>';
                    echo '<td>'. $row['username'] .'</td>';
                    echo '<td>'. $row['email'] .'</td>';
                    echo '<td width="100"></td>';
                    echo '<td>'. ($row['blog'] == 1 ? '<a href="php/deactivate.php?service=blog&accountID='. $row['accountID'] .'">Deaktivera</a>' : '<a href="php/activate.php?service=blog&accountID='. $row['accountID'] .'">Aktivera</a>') .'</td>';
                    echo '<td>'. ($row['calendar'] == 1 ? '<a href="php/deactivate.php?service=calendar&accountID='. $row['accountID'] .'">Deaktivera</a>' : '<a href="php/activate.php?service=calendar&accountID='. $row['accountID'] .'">Aktivera</a>') .'</td>';
                    echo '<td>'. ($row['game'] == 1 ? '<a href="php/deactivate.php?service=game&accountID='. $row['accountID'] .'">Deaktivera</a>' : '<a href="php/activate.php?service=game&accountID='. $row['accountID'] .'">Aktivera</a>') .'</td>';
                    echo '<td>'. ($row['wiki'] == 1 ? '<a href="php/deactivate.php?service=wiki&accountID='. $row['accountID'] .'">Deaktivera</a>' : '<a href="php/activate.php?service=wiki&accountID='. $row['accountID'] .'">Aktivera</a>') .'</td>';
                    echo '</tr>';
                }

            ?>
        </table>
    </div>
</body>
</html>