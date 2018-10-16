<?php

    class Input
    {
        /**
         * Sanitize an element for html entities 
         * @param dirty
         */
        public static function sanitize($dirty)
        {
            return htmlentities($dirty, ENT_QUOTES, "UTF-8");
        }

        /**
         * Get POST/GET var value
         * @param input
         */
        public static function get($input)
        {
            if (isset($_POST[$input]))
            {
                return self::sanitize($_POST[$input]);
            } elseif (isset($_GET[$input]))
            {
                return self::sanitize($_GET[$input]);
            }
        }

    // EOF
    }