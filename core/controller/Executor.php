<?php

class Executor {
    private static $lastError;

    public static function doit($sql){
        $con = Database::getCon();
        if(Core::$debug_sql){
            print "<pre>".$sql."</pre>";
        }
        $result = $con->query($sql);
        if (!$result) {
            self::$lastError = $con->error;
            return false;
        }
        return array($result, $con->insert_id);
    }

    public static function getLastError() {
        return self::$lastError;
    }
}
?>
