<?php
    $input = json_decode(file_get_contents("../json/get-all-blogs-request.json"), true);
    try{
        include "../../utility/utility.php";
        $connection = new DBConnection();

    $sql = "SELECT * FROM blog";
    $result = $connection->query($sql);
    if(count($result) >= 1){
        $response = [
            "status"=>true,
            "message"=>"Bloggar hämtade",
            "blogs"=>$result
        ];
    }else{     
        throw new Exception("Kunde inte hämta bloggar");
    }
    
    }catch(Exception $exc){
        $response = [
            "status"=>false,
            "message"=>$exc->getMessage()
        ];
    }
    echo json_encode($response); 
?>