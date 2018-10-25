<?php
    include_once '../../utility/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('php://input'), true);

        Input::validate($input, [
            'wikiID' => null
        ]);

        

        $connection = new DBConnection();

        if(count($connection->query('SELECT 1 FROM admin_wiki WHERE activated_tp = 1 AND activated_user = 1 AND forWikiID = ?', [$input['wikiID']])) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }
        
        $limit = min($input['limit'] ?? 24, 24);
        $offset = $input['offset'] ?? 0;

        $date_from = $input['date-form'] ?? '1971-01-01 12:00';
        $date_to = $input['date-to'] ?? '2038-01-01 12:00';

        $articleID = $input['articleID'] ?? NULL;

        if($articleID === NULL)
        {
            $result = $connection->query(
                'SELECT
                    versionID,
                    articleID,
                    title,
                    content,
                    `date`,
                    forVersionID,
                    forAccountID AS "accountID"
                FROM article
                    INNER JOIN articleversion
                        ON forArticleID = articleID
                WHERE forWikiID = ? AND (`date` BETWEEN ? AND ?)
                ORDER BY `date` DESC
                LIMIT '. $offset .','. $limit,
                [
                    $input['wikiID'],
                    $date_from,
                    $date_to
                ]
            );
        } else
        {
            $result = $connection->query(
                'SELECT
                    versionID,
                    articleID,
                    title,
                    content,
                    `date`,
                    forVersionID,
                    forAccountID AS "accountID"
                FROM article
                    INNER JOIN articleversion
                        ON forArticleID = articleID
                WHERE forWikiID = ? AND (`date` BETWEEN ? AND ?) AND articleID = ?
                ORDER BY `date` DESC
                LIMIT '. $offset .','. $limit,
                [
                    $input['wikiID'],
                    $date_from,
                    $date_to,
                    $input['articleID']
                ]
            );
        }

        


        $articles = [];

        foreach($result as $row)
        {
            if(!isset($articles[$row['articleID']])) $articles[$row['articleID']] = [];

            $articles[$row['articleID']]['articleID'] = $row['articleID'];
            $articles[$row['articleID']]['currentVersionID'] = $row['forVersionID'];
            
            if(!isset($articles[$row['articleID']]['history'])) $articles[$row['articleID']]['history'] = [];

            $articles[$row['articleID']]['history'][] = [
                'versionID' => $row['versionID'],
                'date' => $row['date'],
                'title' => $row['title'],
                'content' => $row['content'],
                'accountID' => $row['accountID']
            ];
        }
        $articles = array_values($articles);
    
        $response = [
            'status' => true,
            'message' => 'Ändringshistorik hämtad',
            'articles' => $articles
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