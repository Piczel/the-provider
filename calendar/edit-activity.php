<?php
 
 include '../utility/utility.php';
 
     $response = null;
     try
     {
         $input = json_decode(file_get_contents("json/request/edit-activity.json"), true);
 
         if(!Token::verify($input["accountID"], $input["token"]))
         {
             throw new Exception("Användande av felaktig token");
        }
         $connection = new DBConnection();
        $result = $connection->query("UPDATE activity SET name = 'Inte Cardinal', location = 'Inte Pinegrove', description = 'Inte Musik', startTime = '2010-10-10 12:00', endTime = '2012-10-10 21:00' WHERE activityID = 4");
         $response = [
            "status" => true,
             "message" => "Aktivitet redigerad",
         ];
     } catch(Exception $exc)
     {
         $response = [
             "status" => false,
             "message" => $exc->getMessage()
         ];
     } finally
     {
         echo json_encode($response);
     }
 ?>