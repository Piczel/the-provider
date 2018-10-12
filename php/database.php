<?php
class DB{
var $db;
            function __construct(
                $host = "localhost",
                $user = "root",
                $password = "",
                $database = "the_provider"
            ){
                $this->db = new mysqli($host, $user, $password, $database);
                if($this->db->connect_error){
                    echo $this->db->connect_errno;
                }
                $this->db->set_charset("utf8");
            }
                function getData($SQL){
                    $result = $this->db->query($SQL);
                    $retval = array();
                    while($row = $result->fetch_row()){
                        array_push($retval,$row);
                    }
                        return $retval;
                }
                    
                function execute($SQL){
                    return $this->db->query($SQL);
                }
                
}

?>