<?php
    include_once 'php/database.php';
    include_once 'php/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/delete-wiki.json'), true);

        Input::validate($input, [
            'adminID' => null,
            'token' => 20,
            'wikiID' => null
        ]);

        Token::verify($input['adminID'], $input['token']);

        $connection = new DBConnection();
        
        # Is the wiki owned by the adminID
        if(count($wiki = $connection->query(
            'SELECT `name` FROM wiki WHERE wikiID = ? AND forAccountID = ?',
            [$input['wikiID'], $input['adminID']]
        )) != 1) {
            throw new Exception('Wikit tillhör inte dig');
        }

        # Delete the wiki
        if(!$connection->execute(
            'DELETE FROM wiki WHERE wikiID = ? AND forAccountID = ?',
            [$input['wikiID'], $input['adminID']]
        )) {
            throw new Exception('Kunde inte ta bort wikit (wikiID: '. $input['wikiID'] .')');
        }

        $response = [
            'status' => true,
            'message' => 'Wikit med namn "'. $wiki[0]['name'] .'" togs bort'
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