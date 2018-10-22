<?php
    include_once '../../utility/utility.php';


    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('../json/request/'), true);

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
            if(!$connection->execute($sql, [$setting, $input['wikiID'], $input['accountID']]))
            {
                throw new Exception('Kunde inte uppdatera inställning: '.$setting_name);
            }
                        
        }
        

        $response = [
            'status' => true,
            'message' => ''
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