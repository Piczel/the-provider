<?php
    session_start();
    $location = '';
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
                $admin = $connection->query('SELECT 1 FROM admin_blog WHERE forAccountID = ?', [$_GET['accountID']]);
                if(count($admin) > 0)
                {
                    # Blog exists
                    if(!$connection->execute('UPDATE admin_blog SET activated_tp = 1 WHERE forAccountID = ?', [$_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte uppdatera inställning');
                    }

                    $message = 'Blogg aktiverades';
                } else 
                {
                    # Blog doesn't exist, create one
                    if(!$connection->execute('INSERT INTO blog (title, forAccountID) VALUES (?, ?)', ['Ny blog', $_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte skapa blogg');
                    }
                    $blogID = $connection->insert_id();
                    if(!$connection->execute('INSERT INTO admin_blog (forAccountID, forBlogID) VALUES (?, ?)', [$_GET['accountID'], $blogID]))
                    {
                        throw new Exception('Kunde inte skapa koppling mellan konto och blogg');
                    }
                    if(!$connection->execute('INSERT INTO blog_account (forBlogID, forAccountID) VALUES (?, ?)', [$blogID, $_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte bjuda in administratör till blogg');
                    }

                    $message = 'Blogg skapades och aktiverades';
                }
                break;
            case 'calendar':
                $admin = $connection->query('SELECT 1 FROM admin_calendar WHERE forAccountID = ?', [$_GET['accountID']]);
                if(count($admin) > 0)
                {
                    # Calendar exists
                    if(!$connection->execute('UPDATE admin_calendar SET activated_tp = 1 WHERE forAccountID = ?', [$_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte uppdatera inställning');
                    }

                    $message = 'Kalender aktiverades';
                } else 
                {
                    # Calendar doesn't exist, create one
                    if(!$connection->execute('INSERT INTO calendar (calendarID) VALUES (NULL)', []))
                    {
                        throw new Exception('Kunde inte skapa kalender');
                    }
                    if(!$connection->execute('INSERT INTO admin_calendar (forAccountID, forCalendarID) VALUES (?, ?)', [$_GET['accountID'], $connection->insert_id()]))
                    {
                        throw new Exception('Kunde inte skapa koppling mellan konto och kalender');
                    }

                    $message = 'Kalender skapades och aktiverades';
                }
                break;
            case 'game':
                $admin = $connection->query('SELECT 1 FROM admin_game WHERE forAccountID = ?', [$_GET['accountID']]);
                if(count($admin) > 0)
                {
                    # Game exists
                    if(!$connection->execute('UPDATE admin_game SET activated_tp = 1 WHERE forAccountID = ?', [$_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte uppdatera inställning');
                    }

                    $message = 'Spel aktiverades';
                } else 
                {
                    # Game doesn't exist, create one
                    if(!$connection->execute('INSERT INTO game (`name`) VALUES (?)', ['Nytt spel']))
                    {
                        throw new Exception('Kunde inte skapa spel');
                    }
                    if(!$connection->execute('INSERT INTO admin_game (forAccountID, forGameID) VALUES (?, ?)', [$_GET['accountID'], $connection->insert_id()]))
                    {
                        throw new Exception('Kunde inte skapa koppling mellan konto och spel');
                    }

                    $message = 'Spel skapades och aktiverades';
                }
                break;
            case 'wiki':
                $admin = $connection->query('SELECT 1 FROM admin_wiki WHERE forAccountID = ?', [$_GET['accountID']]);
                if(count($admin) > 0)
                {
                    # Wiki exists
                    if(!$connection->execute('UPDATE admin_wiki SET activated_tp = 1 WHERE forAccountID = ?', [$_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte uppdatera inställning');
                    }

                    $message = 'Wiki aktiverades';
                } else 
                {
                    # Wiki doesn't exist, create one
                    if(!$connection->execute('INSERT INTO wiki (`name`, `description`, forAccountID) VALUES (?, ?, ?)', ['Nytt wiki', '', $_GET['accountID']]))
                    {
                        throw new Exception('Kunde inte skapa wiki');
                    }
                    if(!$connection->execute('INSERT INTO admin_wiki (forAccountID, forWikiID) VALUES (?, ?)', [$_GET['accountID'], $connection->insert_id()]))
                    {
                        throw new Exception('Kunde inte skapa koppling mellan konto och wiki');
                    }

                    $message = 'Wiki skapades och aktiverades';
                }
                break;
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