<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('php://input'), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'wikiID' => null,
            'name' => 100,
            'description' => 3000
        ]);

        if(!Token::verify($input['accountID'], $input['token']))
        {
            throw new Exception('Felaktig token');
        }

        $connection = new DBConnection();
        
        $SQL = 'SELECT activated_tp, activated_user FROM admin_wiki WHERE forAccountId = ? AND forWikiID = ?';
        $status = $connection->query($SQL, [$input['accountID'],$input['wikiID']]);
        if(count($status)<1){
            throw new Exception("Du har inget wiki.");
        }
        if($status[0]['activated_tp'] != 1 && $status[0]['activated_user'] != 1){
            throw new Exception("The service is not activated.");
        }

        $SQL = 'UPDATE wiki SET `name` = ?, `description` = ? WHERE wikiID = ?';
        if(!$connection->execute($SQL, [$input['name'],$input['description'], $input['wikiID']])){
            throw new Exception("Kunde inte uppdatera wikiinformation"); 
        }

        $response = [
            'status' => true,
            'message' => 'Wikiinformation uppdaterades'
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