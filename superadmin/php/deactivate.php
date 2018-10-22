<?php
    session_start();
    $location = '';
    $message = '';
    try {
    
        if(!isset($_SESSION['superadmin']))
        {
            throw new Exception('Du är inte inloggad som superadministratör');
        }

        include "../../utility/utility.php";

        Input::validate($_GET, [
            'service' => null,
            'accountID' => null
        ]);

        $connection = new DBConnection();

        switch($_GET['service'])
        {
            case 'blog':
                $sql = 'UPDATE admin_blog SET activated_tp = 0 WHERE forAccountID = ?';
                $message = 'Blogg deaktiverades';
                break;
            case 'calendar':
                $sql = 'UPDATE admin_calendar SET activated_tp = 0 WHERE forAccountID = ?';
                $message = 'Kalender deaktiverades';
                break;
            case 'game':
                $sql = 'UPDATE admin_game SET activated_tp = 0 WHERE forAccountID = ?';
                $message = 'Spel deaktiverades';
                break;
            case 'wiki':
                $sql = 'UPDATE admin_wiki SET activated_tp = 0 WHERE forAccountID = ?';
                $message = 'Wiki deaktiverades';
                break;
        }

        if(!$connection->execute($sql, [$_GET['accountID']]))
        {
            throw new Exception('Kunde inte uppdatera inställning');
        }
        

    } catch(Exception $exc)
    {
        $_SESSION['activationMessage'] = $exc->getMessage();
    } finally
    {
        $_SESSION['activationMessage'] = $message;
        header("Location: ../admin.php");
    }
?>