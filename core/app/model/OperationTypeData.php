<?php
class OperationTypeData {
    public static $tablename = "operation_type";

    public function __construct(){
        $this->name = "";
    }

    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (name) VALUES (?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $this->name);
        $stmt->execute();
        return $stmt;
    }

    public static function delById($id){
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt;
    }

    public function del(){
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public static function getById($id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $found = null;
        $data = new OperationTypeData();
        while ($r = $result->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getByName($name){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $found = null;
        $data = new OperationTypeData();
        while ($r = $result->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll(){
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        $cnt = 0;
        while ($r = $result->fetch_array()) {
            $array[$cnt] = new OperationTypeData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $cnt++;
        }
        return $array;
    }
}


?>