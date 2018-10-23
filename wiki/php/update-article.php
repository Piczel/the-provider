<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/update-article.json'), true);

        Input::validate($input, [
            'accountID' => null,
            'token' => 20,
            'article' => null
        ]);

        Input::validate($input['article'], [
            'articleID' => null,
            'title' => 100,
            'content' => null
        ]);

        if(!Token::verify($input['accountID'], $input['token']))
        {
            throw new Exception('Felaktig token');
        }

        $connection = new DBConnection();
        

        # Fetches the wiki and assumes the account is either admin or wikiuser
        # Only the one(s) with a database result is stored in $wikis
        $wikis = array_filter([
            $connection->query('SELECT wikiID, mayEdit AS "setting-edit", mayAccept AS "setting-accept" FROM wiki INNER JOIN admin_wiki ON forWikiID = wikiID INNER JOIN account ON admin_wiki.forAccountID = accountID WHERE accountID = ?', [$input['accountID']]),
            $connection->query('SELECT wikiID, mayEdit AS "setting-edit", mayAccept AS "setting-accept" FROM wiki INNER JOIN wikiuser ON forWikiID = wikiID WHERE wikiuser.forAccountID = ?', [$input['accountID']])
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
            switch($wiki['setting-edit'])
            {
                
                case 'selected':
                    # Check if account has the permission
                    if(count($connection->query('SELECT 1 FROM selected_edit WHERE forAccountID = ? AND forWikiID = ?', [$input['accountID'], $wiki['wikiID']])) < 1)
                    {
                        throw new Exception('Du har inte rättighet att uppdatera artiklar');
                    }
                    break;
                case 'superuser':
                    # Wiki's setting is set to superuser while account isn't
                    throw new Exception('Du har inte rättighet att utföra denna åtgärd');
                    break;
                    
                case 'any':
                    # No permission check needed
                    break;
            }
        }

        # Redundant but will leave for now
        if(count($connection->query('SELECT 1 FROM wikiuser WHERE forWikiID = ?', [$wiki['wikiID']])) < 1)
        {
            # The account is not a wikiuser in the specified wiki
            throw new Exception('Du tillhör inte detta wiki');
        }

        if(count($connection->query('SELECT 1 FROM article WHERE articleID = ? AND forWikiID = ?', [$input['article']['articleID'], $wiki['wikiID']])) < 1)
        {
            # Article not found in users wiki
            throw new Exception('Artikeln finns inte i ditt wiki');
        }

        if(!$connection->execute(
            'INSERT INTO articleversion (title, content, forArticleID, forAccountID) VALUES (?, ?, ?, ?)',
            [
                $input['article']['title'],
                $input['article']['content'],
                $input['article']['articleID'],
                $wiki['wikiID']
            ]
        )) {
            # Could not create an initial version, remove the created article
            $connection->execute('DELETE FROM article WHERE articleID = ?', [$articleID]);
            throw new Exception('Kunde inte skapa en artikelversion');
        }

        $versionID = $connection->insert_id();

        $message = 'Artikeln uppdaterades';

        try {
            if($account['type'] !== 'admin')
            {
                # If account isn't admin, check wiki's settings
                switch($wiki['setting-accept'])
                {
                    case 'superuser':
                        # Wiki's setting is set to superuser while account isn't
                        throw new Exception('Förslag på uppdatering lades till');
                        break;
                    case 'selected':
                        if(count($connection->query('SELECT 1 FROM selected_accept WHERE forAccountID = ? AND forWikiID = ?', [$input['accountID'], $wiki['wikiID']])) < 1)
                        {
                            # Account may not accept the content of this article
                            throw new Exception('Förslag på uppdatering lades till');
                        }

                        break;
                    case 'auto':
                        break;
                }
            }

            $connection->execute('UPDATE article SET forVersionID = ?', [$versionID]);
        } catch(Exception $exc)
        {
            # versionID of article not updated
            $message = $exc->getMessage();
        }

        $response = [
            'status' => true,
            'message' => $message,
            'versionID' => $versionID
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