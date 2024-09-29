<?php
class PersonData {
    public static $tablename = "person";
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $image;
    public $password;
    public $created_at;
    public $address1;
    public $email1;
    public $phone1;
 
    public function __construct() {
        // Establecer la zona horaria deseada (reemplaza 'America/Managua' con tu zona horaria)
        date_default_timezone_set('America/Managua'); 
    
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function add_client() { 
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (?, ?, ?, ?, ?, 1, ?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql); 
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta");
        }
        $stmt->bind_param("ssssss", $this->name, $this->lastname, $this->address1, $this->email1, $this->phone1, $this->created_at);
        $stmt->execute();
        return $stmt;
    }
    

    public function add_provider() { 
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (?, ?, ?, ?, ?, 2, ?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);

        if ($stmt === false) {
            die("Error en la preparación de la consulta");
        }
        $stmt->bind_param("ssssss", $this->name, $this->lastname, $this->address1, $this->email1, $this->phone1, $this->created_at);
        $stmt->execute();
        return $stmt;
    }
    

    public static function delById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt;
    }

    public function del() {
        $con = Database::getCon(); 
    
        // Primero, actualizamos el campo person_id a NULL para que se pueda eliminar el proveedor
        $updateSql = "UPDATE sell SET person_id = NULL WHERE person_id = ?";
        $updateStmt = $con->prepare($updateSql);
    
        if ($updateStmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
    
        $updateStmt->bind_param("i", $this->id);
    
        if (!$updateStmt->execute()) {
            throw new Exception("Error al eliminar el proveedor");
        }

        //luego si podemos elimnar
    
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $stmt = $con->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
        
        $stmt->bind_param("i", $this->id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar el proveedor");
        }
        
        return $stmt;
    }
    

    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET name=?, email1=?, address1=?, lastname=?, phone1=? WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $this->name, $this->email1, $this->address1, $this->lastname, $this->phone1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update_passwd() {
        $sql = "UPDATE " . self::$tablename . " SET password=? WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $this->password, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = new PersonData();
        while ($r = $result->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->address1 = $r['address1'];
            $data->phone1 = $r['phone1'];
            $data->email1 = $r['email1'];
            $data->created_at = $r['created_at'];
            break;
        }
        return $data;
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        $cnt = 0;
        while ($r = $result->fetch_array()) {
            $array[$cnt] = new PersonData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name'];
            $array[$cnt]->lastname = $r['lastname'];
            $array[$cnt]->email = $r['email1'];
            $array[$cnt]->username = $r['username'];
            $array[$cnt]->phone1 = $r['phone1'];
            $array[$cnt]->address1 = $r['address1'];
            $array[$cnt]->created_at = $r['created_at'];
            $cnt++;
        }
        return $array;
    }

    public static function getClients() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE kind=1 ORDER BY name, lastname";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($r = $result->fetch_array()) {
            $person = new PersonData();
            $person->id = $r['id'];
            $person->name = $r['name'];
            $person->lastname = $r['lastname'];
            $person->email1 = $r['email1'];
            $person->phone1 = $r['phone1'];
            $person->address1 = $r['address1'];
            $person->created_at = $r['created_at'];
            $array[] = $person;
        }
        return $array;
    }

    public static function getProviders() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE kind=2 ORDER BY name, lastname";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($r = $result->fetch_array()) {
            $person = new PersonData();
            $person->id = $r['id'];
            $person->name = $r['name'];
            $person->lastname = $r['lastname'];
            $person->email1 = $r['email1'];
            $person->phone1 = $r['phone1'];
            $person->address1 = $r['address1'];
            $person->created_at = $r['created_at'];
            $array[] = $person;
        }
        return $array;
    }

    public static function getLike($q) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name LIKE ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $like = "%" . $q . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($r = $result->fetch_array()) {
            $person = new PersonData();
            $person->id = $r['id'];
            $person->name = $r['name'];
            $person->email1 = $r['email1'];
            $person->created_at = $r['created_at'];
            $array[] = $person;
        }
        return $array;
    }
}


?>