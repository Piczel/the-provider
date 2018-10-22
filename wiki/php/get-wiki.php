<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/get-wiki.json'), true);

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
        $wiki = $connection->query(
            'SELECT
                wikiID,
                `name`,
                `description`,
                mayEdit AS "may-edit",
                mayAccept AS "may-accept",
                mayAssignEdit AS "may-assign-edit",
                mayAssignAccept AS "may-assign-accept"
            FROM wiki
            WHERE forAccountID = ?',
            [$input['accountID']]

        );
        if(count($wiki)<1){
            throw new Exception(
                "Kunde inte hitta ditt wiki."
            );
        }
        $SQL = "SELECT activated_tp, activated_user FROM admin_wiki WHERE forAccountId = ? AND forWikiID = ?";
        $status = $connection->query($SQL,[$input['accountID'], $wiki[0]["wikiID"]]);
        if(count($status)<1){
            throw new Exception("Du har inget wiki.");
        }
        if($status[0]['activated_tp'] != 1 && $status[0]['activated_user'] != 1){
            throw new Exception("The service is not activated.");
        }

        
       

        $response = [
            'status' => true,
            'message' => '',
            'wiki' => $wiki[0]
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