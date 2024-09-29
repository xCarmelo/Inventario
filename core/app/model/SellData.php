<?php
class SellData {
    public static $tablename = "sell";

    public function __construct() {
        // Establecer la zona horaria deseada (reemplaza 'America/Managua' con tu zona horaria)
        date_default_timezone_set('America/Managua'); 
    
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function getPerson() {
        return PersonData::getById($this->person_id);
    }

    public function getUser() {
        return UserData::getById($this->user_id);
    }

    public function add() {
        $con = Database::getCon();
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (total, discount, user_id, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ddis", $this->total, $this->discount, $this->user_id, $this->created_at);
        $stmt->execute();
        return array($stmt->get_result(), $con->insert_id);
    }

    public function add_re() {
        $con = Database::getCon();
        $operation_type_id = 1;
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (user_id, operation_type_id, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $this->user_id, $operation_type_id, $this->created_at);
        $stmt->execute();
        return array($stmt->get_result(), $con->insert_id); 
    }

    public function add_with_client() {
        $con = Database::getCon();
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (total, discount, person_id, user_id, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ddiis", $this->total, $this->discount, $this->person_id, $this->user_id, $this->created_at);
        $stmt->execute();
        return array($stmt->get_result(), $con->insert_id);
    }

    public function add_re_with_client() {
        $con = Database::getCon();
        $operation_type_id = 1;
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (person_id, operation_type_id, user_id, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $this->person_id, $operation_type_id, $this->user_id, $this->created_at);
        $stmt->execute();
        return array($stmt->get_result(), $con->insert_id);
    }

    public static function delById($id) {
        $con = Database::getCon();
        $stmt = $con->prepare("DELETE FROM ".self::$tablename." WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function del() {
        $con = Database::getCon();
        $stmt = $con->prepare("DELETE FROM " . self::$tablename . " WHERE id = ?");
        
        // Verifica si la preparación del statement fue exitosa
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
    
        // Vincula el parámetro id
        $stmt->bind_param("i", $this->id);
    
        // Verifica si la ejecución fue exitosa
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar el registro");
        }
    
        // Retorna el statement
        return $stmt;
    }
    

    public function update_box() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE ".self::$tablename." SET box_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $this->box_id, $this->id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function getById($id) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM ".self::$tablename." WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $query = $stmt->get_result();
        return Model::one($query, new SellData());
    }

    public static function getSells() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 2 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData()); 
    }

    public static function getSellsUnBoxed() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 2 AND box_id IS NULL ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getByBoxId($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 2 AND box_id = $id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getRes() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 1 ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByPage($start_from, $limit) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id <= $start_from LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByDateOp($start, $end, $op) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE DATE(created_at) >= \"$start\" AND DATE(created_at) <= \"$end\" AND operation_type_id = $op ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new SellData());
    }

    public static function getAllByDateBCOp($clientid, $start, $end, $op) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE DATE(created_at) >= \"$start\" AND DATE(created_at) <= \"$end\" AND person_id = $clientid AND operation_type_id = $op ORDER BY created_at DESC";
        $query = Executor::doit($sql);
    
        // Verificar si la consulta fue exitosa
        if (!$query) {
            // Obtener y mostrar el error de SQL
            die("Error en la consulta SQL: " . Executor::getLastError());
        }
    
        return Model::many($query[0], new SellData());
    }
    
}
?>
