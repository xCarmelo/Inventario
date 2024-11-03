<?php
class DiscardData {
    public static $tablename = "sell";

    public function __construct() { 
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
        
        // Prepara la consulta
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (user_id, created_at, operation_type_id) VALUES (?, ?, ?)");
        
        // Vincula los parámetros por referencia
        $stmt->bind_param("isi", $this->user_id, $this->created_at, $this->operation_type_id);
        
        // Ejecuta la consulta
        $stmt->execute();
        
        return array($stmt->get_result(), $con->insert_id);
    }
    

    public function add_re() {
        $con = Database::getCon();
        $operation_type_id = 3; // Código para desechos
        $stmt = $con->prepare("INSERT INTO ".self::$tablename." (total, reason, user_id, operation_type_id, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisi", $this->reason, $this->total, $this->user_id, $operation_type_id, $this->created_at);
        $stmt->execute();
        return array($stmt->get_result(), $con->insert_id);
    }

    public static function getById($id) {
        $sql = "SELECT * FROM ".self::$tablename." WHERE id = $id";
        $query = Database::getCon()->query($sql);
        return $query->fetch_assoc();
    }

    public static function getAll() {
        $sql = "SELECT * FROM ".self::$tablename." WHERE operation_type_id = 3";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }
    
}
?>
