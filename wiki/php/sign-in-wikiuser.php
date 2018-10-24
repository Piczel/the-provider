<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('php://input'), true);

        Input::validate($input, [
            'username' => 50,
            'password' => 100
        ]);

        $connection = new DBConnection();

        if(count($connection->query('SELECT 1 FROM admin_wiki INNER JOIN wikiuser ON wikiuser.forWikiID = admin_wiki.forWikiID INNER JOIN account ON wikiuser.forAccountID = accountID WHERE activated_tp = 1 AND activated_user = 1 AND account.username = ?', [$input['username']])) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }
        
        if(!($generated = Token::generate($input['username'], $input['password'])))
        {
            throw new Exception('Felaktigt användarnamn eller lösenord');
        }

        $response = [
            'status' => true,
            'message' => 'Användaren loggades in',
            'accountID' => $generated['accountID'],
            'user-token' => $generated['token']
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