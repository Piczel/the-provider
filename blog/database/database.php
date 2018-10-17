<?php

    class DBConnection
    {

        private static $connection = null;

        function __construct($file = "settings.ini")
        {
            if(!$settings = parse_ini_file($file, TRUE)) throw new exception("Unable to open " . $file . ".");
        
            $dns = 
                $settings["mysql"]["driver"] .
                ":host=" . $settings["mysql"]["host"] .
                ((!empty($settings["mysql"]["port"])) ? (";port=" . $settings["database"]["port"]) : "") .
                ";dbname=" . $settings["mysql"]["dbname"] . 
                ";charset=utf8";
        
            self::$connection = new PDO($dns, $settings["mysql"]["username"], $settings["mysql"]["password"]);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // PDO::ERRMODE_SILENT
            self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            
        }

        function prepare($sql)
        {
            try {
                return self::$connection->prepare($sql);
            } catch(PDOException $exc) {
                return null;
            }
        }

        function query($sql, $values = [])
        {
            try {
                $statement = self::$connection->prepare($sql);
                $statement->execute($values);
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $exc) {
                return null;                
            }
        }

        function execute($sql, $values = [])
        {
            try {
                $statement = self::$connection->prepare($sql);
                return $statement->execute($values);
            } catch(PDOException $exc) {
                return false;                
            }
        }

        function insert_id()
        {
            return self::$connection->lastInsertId();
        }

        function error()
        {
            $info = self::$connection->errorInfo();
            return "ERROR: ".$info[0]." ".$info[2];
        }
    }

    
?>