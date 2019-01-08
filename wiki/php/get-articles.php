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

        $limit = min($input['limit'] ?? 24, 24);
        $offset = $input['offset'] ?? 0;

        $connection = new DBConnection();

        if(count($connection->query('SELECT 1 FROM admin_wiki WHERE activated_tp = 1 AND activated_user = 1 AND forWikiID = ?', [$input['wikiID']])) < 1)
        {
            # The service is not turned on for specific wiki
            throw new Exception('Tjänsten är inte aktiverad');
        }

        $articles = [];

        switch(Input::either($input, [
            'search' => 100,
            'articleID' => null,
            'tags' => null
        ])) {
            case 'search':
                $articles = $connection->query(
                    'SELECT
                        articleID,
                        versionID,
                        title,
                        content
                    FROM article
                        INNER JOIN articleversion
                            ON forVersionID = versionID
                    WHERE UPPER(title) LIKE UPPER(?)
                        AND forWikiID = ?
                    LIMIT '. $offset .','. $limit,
                    [
                        '%'. $input['search'] .'%',
                        $input['wikiID']
                    ]
                );
                break;
            case 'articleID':
                $articles = $connection->query(
                    'SELECT
                        articleID,
                        versionID,
                        title,
                        content
                    FROM article
                        INNER JOIN articleversion
                            ON forVersionID = versionID
                    WHERE articleID = ?
                        AND forWikiID = ?
                    LIMIT '. $offset .','. $limit,
                    [
                        $input['articleID'],
                        $input['wikiID']
                    ]
                );
                break;
            case 'tags':

                $query = 
                    'SELECT
                        articleID,
                        articleversion.versionID,
                        title,
                        content
                    FROM article
                        INNER JOIN articleversion
                            ON forVersionID = articleversion.versionID';

                $where = '';
                $parameters = [];

                for($i = 0; $i < count($input['tags']); $i++)
                {
                    $tag = $input['tags'][$i];
                    $where .= 
                        ' INNER JOIN (
                            SELECT 
                                av'. $i .'.versionID
                            FROM articleversion_tag
                                INNER JOIN tag
                                    ON forTagID = tagID
                                INNER JOIN articleversion AS av'. $i .'
                                    ON av'. $i .'.versionID = forArticleVersionID
                            WHERE tag.`name` = ?
                        ) AS a'. $i .'
                            ON a'. $i .'.versionID = articleversion.versionID';
                    
                    $parameters[] = $tag;
                }

                $parameters[] = $input['wikiID'];

                $where .= ' WHERE forWikiID = ?';


                $limit = ' LIMIT '. $offset .','. $limit;

                $articles = $connection->query(
                    $query . $where . $limit,
                    $parameters
                );
                break;
        }

        $tag_statement = $connection->prepare('SELECT `name` AS "name" FROM tag INNER JOIN articleversion_tag ON forTagID = tagID WHERE forArticleVersionID = ?');

        foreach($articles as &$article)
        {
            $tag_statement->execute([$article['versionID']]);
            
            $article['tags'] = $tag_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        $response = [
            'status' => true,
            'message' => '',
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