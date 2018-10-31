<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('php://input'), true);

        $accountID = $input['accountID'] ?? null;
        $token = $input['token'] ?? null;

        if($accountID !== null && $token !== null)
        {
            if(!Token::verify($input['accountID'], $input['token']))
            {
                throw new Exception('Felaktig token');
            }
            
            $as_admin = true;
        } else
        {
            $as_admin = false;
        }

        $connection = new DBConnection();

        if($as_admin)
        {
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
                    INNER JOIN admin_wiki
                        ON forWikiID = wikiID
                WHERE admin_wiki.forAccountID = ?',
                [$input['accountID']]
            );
        } else {

            Input::validate($input, [
                'wikiID' => null
            ]); 

            $wiki = $connection->query(
                'SELECT
                    wikiID,
                    `name`,
                    `description`
                FROM wiki
                WHERE wikiID = ?',
                [$input['wikiID']]
            );
        }
    
        if(count($wiki) < 1){
            throw new Exception("Kunde inte hitta wiki");
        }


        $status = $connection->query('SELECT 1 FROM admin_wiki WHERE activated_tp = 1 AND activated_user = 1 AND forWikiID = ?',[$wiki[0]["wikiID"]]);
        if(count($status) < 1)
        {
            throw new Exception("Tjänsten är inte aktiverad");
        }        
       

        $response = [
            'status' => true,
<<<<<<< HEAD
            'message' => 'Wikit hämtades',
=======
            'message' => 'Wiki hämtat',
>>>>>>> 03744393549daf1d57f40378ffeb803d64fb3624
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