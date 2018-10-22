<?php
    include_once 'utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/generate-token.json'), true);

        Input::validate($input, [
            'username' => 50,
            'password' => 100
        ]);
        
        if(!($generated = Token::generate($input['username'], $input['password'])))
        {
            throw new Exception('Felaktigt användarnamn eller lösenord');
        }

        $response = [
            'status' => true,
            'message' => 'Token genererad',
            'accountID' => $generated['accountID'],
            'token' => $generated['token']
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