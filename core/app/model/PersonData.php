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

    public function __construct() {}

    public function add_client() {
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (?, ?, ?, ?, ?, 1, NOW())";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $this->name, $this->lastname, $this->address1, $this->email1, $this->phone1);
        $stmt->execute();
        return $stmt;
    }

    public function add_provider() {
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (?, ?, ?, ?, ?, 2, NOW())";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $this->name, $this->lastname, $this->address1, $this->email1, $this->phone1);
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
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
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