<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/delete-article.json'), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'articleID' => null
        ]);


        if(!Token::verify($input['accountID'], $input['token']))
        {
            throw new Exception('Felaktig token');
        }

        $connection = new DBConnection();
        

        # Fetches the wiki and assumes the account is either admin or wikiuser
        # Only the one(s) with a database result is stored in $wikis
        $wikis = array_filter([
            $connection->query('SELECT wikiID, mayAccept AS "setting-accept" FROM wiki INNER JOIN admin_wiki ON forWikiID = wikiID INNER JOIN account ON admin_wiki.forAccountID = accountID WHERE accountID = ?', [$input['accountID']]),
            $connection->query('SELECT wikiID, mayAccept AS "setting-accept" FROM wiki INNER JOIN wikiuser ON forWikiID = wikiID WHERE wikiuser.forAccountID = ?', [$input['accountID']])
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
            switch($wiki['setting-accept'])
            {
                
                case 'selected':
                    # Check if account has the permission
                    if(count($connection->query('SELECT 1 FROM selected_accept WHERE forAccountID = ? AND forWikiID = ?', [$input['accountID'], $wiki['wikiID']])) < 1)
                    {
                        throw new Exception('Du har inte rättighet att ta bort artiklar');
                    }
                    break;
                case 'superuser':
                    # Wiki's setting is set to superuser while account isn't
                    throw new Exception('Du har inte rättighet att utföra denna åtgärd');
                    break;
                    
                case 'auto':
                    # When set to auto user needs at least edit permission
                    if(count($connection->query('SELECT 1 FROM selected_edit WHERE forAccountID = ? AND forWikiID = ?', [$input['accountID'], $wiki['wikiID']])) < 1)
                    {
                        throw new Exception('Du har inte rättighet att ta bort artiklar');
                    }
                    break;
            }
        }

        if(count($connection->query('SELECT 1 FROM article WHERE articleID = ? AND forWikiID = ?', [$input['articleID'], $wiki['wikiID']])) < 1)
        {
            # Article not found in users wiki
            throw new Exception('Artikeln finns inte i ditt wiki');
        }

        if(!$connection->execute('UPDATE article SET forVersionID = NULL WHERE articleID = ?', [$input['articleID']]))
        {
            throw new Exception('Kunde inte ta bort artikel');
        }

        
        $response = [
            'status' => true,
            'message' => 'Artikeln togs bort (men finns kvar i redigeringshistoriken)'
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