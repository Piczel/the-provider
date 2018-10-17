<?php
    include_once 'php/database.php';
    include_once 'php/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/update-settings.json'), true);

        Input::validate($input, [
            'adminID' => null,
            'token' => 20,
            'wikiID' => null,
            'settings' => null
        ]);

        Token::verify($input['adminID'], $input['token']);

        $connection = new DBConnection();
                
        foreach($input['settings'] as $setting_name => $setting)
        {
            switch($setting_name)
            {
                case 'may-edit':
                    $column = 'mayEdit';
                    break;
                case 'may-accept':
                    $column = 'mayAccept';
                    break;
                case 'may-assign-edit':
                    $column = 'mayAssignEdit';
                    break;
                case 'may-assign-accept':
                    $column = 'mayAssignAccept';
                    break;
                default:
                    continue 2;
            }

            $sql = "UPDATE wiki SET $column = ? WHERE wikiID = ? AND forAccountID = ?";
            if(!$connection->execute($sql, [$setting, $input['wikiID'], $input['adminID']]))
            {
                throw new Exception('Kunde inte uppdatera inställning: '.$setting_name);
            }
            
        }

        $response = [
            'status' => true,
            'message' => 'Angivna inställningarna uppdaterades'
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