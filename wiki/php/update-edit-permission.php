<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/update-edit-permission.json'), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'forAccountID' => null,
            'permission' => null
        ]);

        $connection = new DBConnection();
        
        
        if(!Token::verify($input['accountID'], $input['token']))
        {
            # User not signed in correctly
            throw new Exception('Felaktig token');
        }
        
        # Fetches the wiki and assumes the account is either admin or wikiuser
        # Only the one(s) with a database result is stored in $wikis
        $wikis = array_filter([
            $connection->query('SELECT wikiID, mayAssignEdit AS "setting" FROM wiki INNER JOIN admin_wiki ON forWikiID = wikiID INNER JOIN account ON admin_wiki.forAccountID = accountID WHERE accountID = ?', [$input['accountID']]),
            $connection->query('SELECT wikiID, mayAssignEdit AS "setting" FROM wiki INNER JOIN wikiuser ON forWikiID = wikiID WHERE wikiuser.forAccountID = ?', [$input['accountID']])
        ]);

        if(count($wikis) < 1)
        {
            # None of the queries returned a result
            throw new Exception('Ditt konto tillhör inte något wiki');
        }
        
        $wiki = reset($wikis)[0];

        if(count($connection->query('SELECT 1 FROM admin_wiki WHERE activated_tp = 1 AND activated_user = 1 AND forWikiID = ?', [$wiki['wikiID']])) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }
        
        $account = $connection->query('SELECT `type` FROM account WHERE accountID = ?', [$input['accountID']])[0];
       
        if($account['type'] !== 'admin')
        {
            # If account isn't admin, check wiki's settings

            switch($wiki['setting'])
            {
                case 'selected':
                    # Check if account has the permission
                    if(count($connection->query('SELECT 1 FROM selected_edit WHERE forAccountID = ? AND forWikiID = ?', [$input['accountID'], $wiki['wikiID']])) < 1)
                    {
                        throw new Exception('Du behöver själv ha denna rättighet för att uppdatera andras');
                    }
                    break;
                case 'superuser':
                    # Wiki's setting is set to superuser while account isn't
                    throw new Exception('Du har inte rättighet att utföra denna åtgärd');
                    break;
            }
        }
        
        if(count($connection->query('SELECT 1 FROM wikiuser WHERE forAccountID = ? AND forWikiID = ?', [$input['forAccountID'], $wiki['wikiID']])) < 1)
        {
            # The account is not a wikiuser in the same wiki as the requesting account
            throw new Exception('Användaren finns inte i ditt wiki');
        }

        if($input['permission'] == true)
        {
            $connection->execute('INSERT INTO selected_edit (forWikiID, forAccountID) VALUES (?, ?)', [$wiki['wikiID'], $input['forAccountID']]);
        } else if($input['permission'] == false)
        {
            $connection->execute('DELETE FROM selected_edit WHERE forWikiID = ? AND forAccountID = ?', [$wiki['wikiID'], $input['forAccountID']]);
        } else {
            throw new Exception('Otillåtet värde för "permission": '. $input['permission']);
        }

        $response = [
            'status' => true,
            'message' => 'Tillåtelse uppdaterades korrekt'
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