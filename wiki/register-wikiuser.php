<?php
    include_once 'php/database.php';
    include_once 'php/utility.php';

    $response = null;

    try
    {
        # Decode the input JSON to a PHP array
        $input = json_decode(file_get_contents('json/request/register-wikiuser.json'), true);

        Input::validate($input, [
            'adminID' => null,
            'token' => 20,
            'email' => 100,
            'password' => 100,
            'forename' => 50,
            'surname' => 50
        ]);

        Token::verify($input['adminID'], $input['token']);

        $connection = new DBConnection();
        
        $account = $connection->query('SELECT accountID FROM account WHERE email = ?', [$input['email']]);
        if(count($account) > 0)
        {
            # Account exists in primary table
            $accountID = $account[0]['accountID'];

            $wikiuser = $connection->query('SELECT 1 FROM wikiuser WHERE forAccountID = ?', [$accountID]);
            if(count($wikiuser) > 0)
            {
                # And in inheriting table

                throw new Exception('E-postadressen är redan bunden till ett konto');
            } else
            {
                # But not in inheriting table

                $message = 'Kontot är nu även wikianvändare';
            }
        } else
        {
            # Account does not exist in database

            if(!$connection->execute(
                'INSERT INTO account (email, `password`, forename, surname) VALUES (?, ?, ?, ?)',
                [
                    $input['email'],
                    password_hash($input['password'], PASSWORD_DEFAULT),
                    $input['forename'],
                    $input['surname']
                ]
            )) {
                throw new Exception('Kunde inte registrera konto');
            } else {

                # New account registered

                $accountID = $connection->insert_id();
                $message = 'Nytt konto registrerades';
            }
        }

        if(!$connection->execute(
            'INSERT INTO wikiuser (forAccountID) VALUES (?)',
            [$accountID]
        )) {
            throw new Exception('Kunde inte göra konto till wikianvändare');
        }
        

        $response = [
            'status' => true,
            'message' => $message,
            'accountID' => $accountID
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