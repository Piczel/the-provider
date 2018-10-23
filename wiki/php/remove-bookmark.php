<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/remove-bookmark.json'), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20
        ]);

        if(!Token::verify($input['accountID'], $input['token']))
        {
            throw new Exception('Felaktig token');
        }

        $connection = new DBConnection();
        
        # Code...
        $SQL = 'DELETE FROM bookmark WHERE forAccountID = ? AND forArticleID = ?';
        if(!$connection->execute($SQL, [$input['accountID'], $input['articleID']])){
            throw new Exception('Bokmärke kunde inte raderas');
        }

        $response = [
            'status' => true,
            'message' => 'Bokmärke raderades'
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