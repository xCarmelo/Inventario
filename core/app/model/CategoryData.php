<?php
class CategoryData {
    public static $tablename = "category";
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $image;
    public $password;
    public $created_at;

    public function __construct()
    {
        // Establecer la zona horaria deseada (reemplaza 'America/Managua' con tu zona horaria)
        date_default_timezone_set('America/Managua'); 
    
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function add() {
        $con = Database::getCon();
        $stmt = $con->prepare("INSERT INTO " . self::$tablename . " (name, created_at) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->name, $this->created_at);
        
        if ($stmt->execute()) {
            header("Location: index.php?view=newcategory&result=success");
        } else {
            header("Location: index.php?view=newcategory&result=error");
        }
        $stmt->close();
        $con->close();
        exit;
    }    
    
    

    public static function delById($id) {
        $con = Database::getCon();
        $stmt = $con->prepare("DELETE FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function del() {
        $con = Database::getCon();
        $stmt = $con->prepare("DELETE FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }

    public function update() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $this->name, $this->id);
    
        if ($stmt->execute()) {
            header("Location: index.php?view=editcategory&id=" . $this->id . "&result=success");
        } else {
            header("Location: index.php?view=editcategory&id=" . $this->id . "&result=error");
        }
        $stmt->close();
        $con->close();
        exit;
    }
    

    public static function getById($id) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = new CategoryData();
        if ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->created_at = $r['created_at'];
        }
        return $data;
    }

    public static function getAll() {
        $con = Database::getCon();
        $result = $con->query("SELECT * FROM " . self::$tablename);
        $array = array();
        while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $category = new CategoryData();
            $category->id = $r['id'];
            $category->name = $r['name'];
            $category->created_at = $r['created_at'];
            $array[] = $category;
        }
        return $array;
    }

    public static function getLike($q) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE name LIKE ?");
        $like = "%$q%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
            $category = new CategoryData();
            $category->id = $r['id'];
            $category->name = $r['name'];
            $category->created_at = $r['created_at'];
            $array[] = $category;
        }
        return $array;
    }
}
?>
