<?php
class Model {
    public static function exists($modelname){
        $fullpath = self::getFullpath($modelname);
        return file_exists($fullpath);
    }

    public static function getFullpath($modelname){
        return Core::$root . "core/app/model/" . $modelname . ".php";
    }

    public static function many($query, $aclass) {
        $cnt = 0;
        $array = array();
        while ($r = $query->fetch_array(MYSQLI_ASSOC)) {
            $array[$cnt] = new $aclass;
            foreach ($r as $key => $v) {
                $array[$cnt]->$key = $v;
            }
            $cnt++;
        }
        return $array;
    }

    public static function one($query, $aclass){
        $data = new $aclass;
        if ($r = $query->fetch_array(MYSQLI_ASSOC)) {
            foreach ($r as $key => $v) {
                $data->$key = $v;
            }
        }
        return $data;
    }
}
?>
