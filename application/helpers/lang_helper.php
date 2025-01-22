<?php

class lang_helpers
{

    public static function __($message)
    {
        $result = $message;
        if ($_SESSION['lang'] == 'en') {
            $getData = include('apps/language/en.php');
            if (isset($getData[$message])) {
                $result = $getData[$message];
            }
        }

        return $result;
    }
}
