<?php
    include_once 'php/database.php';
    include_once 'php/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/get-wikiuser.json'), true);

        Input::validate($input, [
            'adminID' => null,
            'token' => 20
        ]);

        
        Token::verify($input['adminID'], $input['token']);
        
        $connection = new DBConnection();
        
        $key = Input::either($input, [
            'accountID' => null,
            'email' => 100
        ]);

        var_dump($input);

        switch($key)
        {
            case 'accountID':
                $wikiuser = $connection->query('SELECT accountID, email, forename, username FROM wikiuser INNER JOIN account ON forAccountID = accountID WHERE accountID = ?', $input['accountID']);
                $err_message = 'Kunde inte hitta användare med angivet konto ID';
                break;
                case 'email':
                $wikiuser = $connection->query('SELECT accountID, email, forename, username FROM wikiuser INNER JOIN account ON forAccountID = accountID WHERE email = ?', $input['email']);
                $err_message = 'Kunde inte hitta användare med angiven e-postadress';
                break;    
        }

        if(count($wikiuser) < 1)
        {
            throw new Exception($err_message);
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