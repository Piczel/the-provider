<?php
    include_once 'php/database.php';
    include_once 'php/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/create-wiki.json'), true);

        Input::validate($input, [
            'adminID' => null,
            'token' => 20,
            'wiki-name' => 100,
            'wiki-description' => 3000
        ]);

        Token::verify($input['adminID'], $input['token']);

        $connection = new DBConnection();
        
        if(!$connection->execute(
            'INSERT INTO wiki (`name`, `description`) VALUES (?, ?)',
            [$input['wiki-name'], $input['wiki-description']]
        )) {
            throw new Exception($connection->error());
        }

        $response = [
            'status' => true,
            'message' => 'Wiki skapades',
            'wikiID' => $connection->insert_id()
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