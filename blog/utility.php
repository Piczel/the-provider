<?php
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