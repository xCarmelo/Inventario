<?php class BoxData {
    public static $tablename = "box";

    public function __construct(){
        $this->name = "";
        $this->lastname = "";
        $this->email = "";
        $this->image = ""; 
        $this->password = "";
    }

    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (created_at) VALUES (NOW())";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return array($stmt, $con->insert_id);
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

    public function update(){
        $sql = "UPDATE " . self::$tablename . " SET name=? WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $this->name, $this->id);
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
        $data = new BoxData();
        while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $data->id = $r['id'];
            $data->created_at = $r['created_at'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll(){
        $sql = "SELECT * FROM " . self::$tablename;
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        $cnt = 0;
        while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $array[$cnt] = new BoxData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->created_at = $r['created_at'];
            $cnt++;
        }
        return $array;
    }

    public static function getLike($q){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name LIKE ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $search = "%$q%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        $cnt = 0;
        while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $array[$cnt] = new BoxData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->created_at = $r['created_at'];
            $cnt++;
        }
        return $array;
    }
}
?>