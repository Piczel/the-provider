<?php
    include_once 'php/database.php';
    include_once 'php/verify-token.php';
    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/'), true);

        Token::verify($input['adminID'], $input['token']);

        # Code...

        $response = [
            'status' => true,
            'message' => ''
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