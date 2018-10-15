<?php
    /*$input = json_decode(file_get_contents("../json/create-post-request.json"), true);
    var_dump($input);
    try{
        /*session_start();
        if(isset($_SESSION["signedInUserid"])){
            throw new Exception("Inte inloggad");
        }
        if($input["uid"] != $_SESSION["signedInUserid"]){
            throw new Exception("Inte inloggad");
        }*/

    include "../database/database.php";
    $connection = new DBconnection();

    $sql = "SELECT * FROM blog";
    $result = $connection->query($sql);
    if(count($result) > 0){
        echo $result;
    }else{
        echo ("FEL");
    }

?>