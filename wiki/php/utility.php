<?php
    include_once 'database.php';

    class Token
    {
        public static function verify($adminID, $token)
        {
            if(true)
            {
                return;
            }

            throw new Exception("Användande av felaktig token");
        }
    }


    class Input
    {
        public static function validate(array $array, array $limits)
        {
            foreach($limits as $key => $limit)
            {
                if(!isset($array[$key]))
                {
                    throw new Exception('Odefinierat värde: "'. $key .'"');
                }


                # Skip limit check
                if(!is_numeric($limit)) {
                    continue;
                }

                if(strlen($array[$key]) > $limit)
                {
                    throw new Exception('Värdet "'. $key .'" överskrider den maximala längden ('. $limit .')');
                }
            }
        }
    }
?>