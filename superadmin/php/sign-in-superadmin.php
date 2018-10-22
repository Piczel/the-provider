<?php

    include '../../utility/utility.php';

    $location = "";
    try
    {
        Input::validate($_POST, [
            'username' => 50,
            'password' => null
        ]);

        if($generated = Token::generate($_POST['username'], $_POST['password'])) {
            $accountID = $generated['accountID'];
            $token = $generated['token'];
        } else {
            throw new Exception('Användarnamnet eller lösenordet är felaktigt');
        }

        if($accountID !== 1337)
        {
            throw new Exception('Du är inte administratör');
        }

        session_start();
        $_SESSION['superadmin'] = $token;

        $location = '../admin.php';
    } catch(Exception $exc)
    {
        session_start();
        $_SESSION['signInMessage'] = $exc->getMessage();
        $location = '../index.php';
    } finally
    {
        header("Location: $location");
    }
?>