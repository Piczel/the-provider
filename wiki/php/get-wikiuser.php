<?php
    include_once '../../utility/utility.php';


    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/get-wikiuser.json'), true);

        # Retrieves the key of the first defined key
        $key = Input::either($input, [
            'accountID' => null,
            'username' => 100
        ]);
            
        $connection = new DBConnection();

        

        switch($key)
        {
            case 'accountID':
                $wikiuser = $connection->query('SELECT accountID, email, forename, username FROM wikiuser INNER JOIN account ON forAccountID = accountID WHERE accountID = ?', [$input['accountID']]);
                $err_message = 'Kunde inte hitta användare med angivet konto ID';
                break;
            case 'username':
                $wikiuser = $connection->query('SELECT accountID, email, forename, username FROM wikiuser INNER JOIN account ON forAccountID = accountID WHERE username = ?', [$input['username']]);
                $err_message = 'Kunde inte hitta användare med det angivna användarnamnet';
                break;    
        }

        if(count($wikiuser) < 1)
        {
            throw new Exception($err_message);
        }

        if(count($connection->query('SELECT 1 FROM admin_wiki INNER JOIN wikiuser ON wikiuser.forWikiID = admin_wiki.forWikiID WHERE activated_tp = 1 AND activated_user = 1 AND wikiuser.forAccountID = ?', [$wikiuser[0]['accountID']])) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }

        $response = [
            'status' => true,
            'message' => 'Användaren hämtad',
            'wikiuser' => $wikiuser[0]
        ];
    } catch(Exception $exc)
    {
        # Catch errors and create response with 'status' set to false
        $response = [
            'status' => false,
            'message' => $exc->getMessage()
        ];
    } finally
    {   
        # Print the response as JSON
        echo json_encode($response);
    }
?>