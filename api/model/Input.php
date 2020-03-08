<?php
    class Input
    {
        public $origin;
        public function __construct($origin)
        {
            /**
             * Here the $origin is defined
             * $origin = ($_GET|$_POST|$_REQUEST) or any array
             */
            $this->origin = $origin;
        }

        public function get($key)
        {
            /**
             * $key is a index for search in $this->origin
             * if the index is not defined or the value is "" the return is null
             * @return string
             */
            if(isset($this->origin[$key]))
            {
                return ($this->origin[$key] == "")?null:$this->origin[$key];
            }
            return null;
        }

        public function validateAllKeys($keys)
        {
            /**
             * verify if all keys is included in $this->origin
             * @return bool
             */
            foreach ($keys as $value) {
                if(!isset($this->origin[$value])) return false;
            }
            return true;
        }

        public static function getBody()
        {
            /**
             * get body of request
             * @return string
             */
            return file_get_contents("php://input");
        }

        public static function getJsonBody()
        {
            /**
             * get string from body and convert to json
             * @return string
             */
            return json_decode(SELF::getBody());
        }
    }
?>