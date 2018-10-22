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
                if(!is_numeric($limit))
                {
                    continue;
                }

                if(strlen($array[$key]) > $limit)
                {
                    throw new Exception('Värdet "'. $key .'" överskrider den maximala längden ('. $limit .')');
                }
            }
        }

        public static function either(array $array, array $limits)
        {
            # Returns the key in the provided array where the key is defined

            foreach($limits as $key => $limit)
            {
                if(!isset($array[$key]))
                {
                    continue;
                }

                # If numeric, do limit check
                if(is_numeric($limit))
                {   
                    if(strlen($array[$key]) > $limit)
                    {
                        throw new Exception('Värdet "'. $key .'" överskrider den maximala längden ('. $limit .')');
                    }
                }
                
                return $key;
            }

            throw new Exception('Inget av värdena "'. implode('", "', array_keys($limits)) .'" är definierade');
        }
    }
?>