<?php
    include_once '../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/register-wikiuser.json'), true);

        Input::validate($input, [
            'wikiID' => null,
            'username' => 50,
            'password' => 100,
            'email' => 100,
            'forename' => 50,
            'surname' => 50
        ]);

        $connection = new DBConnection();
        
        if(count('SELECT 1 FROM admin_wiki WHERE activated_tp = 1 AND activated_user = 1 AND forWikiID = ?', [$input['wikiID']]) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }
        if(count('SELECT 1 FROM account WHERE username = ?', [$input['username']]) > 0)
        {
            # Username taken
            throw new Exception('Användarnamnet är upptaget');
        }

        # Registers account
        if(!($accountID = Account::register(
            $input['email'],
            $input['username'],
            $input['password']
        ))) {
            throw new Exception('Kunde inte registrera konto');
        }

        # Adds data to inheriting table
        if(!$connection->execute(
            'INSERT INTO wikiuser (forAccountID, forWikiID) VALUES (?, ?)',
            [$accountID, $input['wikiID']]
        )) {
            throw new Exception('Kunde inte göra konto till wikianvändare');
        }
        

        $response = [
            'status' => true,
            'message' => $message,
            'accountID' => $accountID
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