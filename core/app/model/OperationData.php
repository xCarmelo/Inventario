<?php
class OperationData {
    public static $tablename = "operation";

    public function __construct(){
        $this->name = "";
        $this->product_id = "";
        $this->q = "";
        $this->cut_id = "";
        $this->operation_type_id = "";
        $this->new_price = "";

        // Establecer la zona horaria deseada (reemplaza 'America/Managua' con tu zona horaria)
        date_default_timezone_set('America/Managua'); 
    
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (product_id, q, operation_type_id, sell_id, created_at, new_price) VALUES (?, ?, ?, ?, ?, ?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $this->created_at = date("Y-m-d H:i:s"); // set created_at to current date and time
        $stmt->bind_param("isiisd", $this->product_id, $this->q, $this->operation_type_id, $this->sell_id, $this->created_at, $this->new_price);
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

    public function del() {
        date_default_timezone_set('America/Managua'); 
        $this->created_at = date("Y-m-d H:i:s");
        $con = Database::getCon(); // Obtiene la conexión a la base de datos
        $sql = "UPDATE " . self::$tablename . " SET operation_type_id = ?, reason_for_return = ?, created_at = ? WHERE id=?";
        $stmt = $con->prepare($sql); // Prepara la consulta SQL
        
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta"); // Lanza una excepción si hay un error
        }
        
        $filtro = 4;
        $stmt->bind_param("issi", $filtro, $this->reason_for_return, $this->created_at, $this->id); // Asocia el parámetro ID
        
        if (!$stmt->execute()) { // Ejecuta la consulta y verifica si hubo un error
            throw new Exception("Error al eliminar el registro");
        }
        
        return $stmt; // Devuelve la declaración ejecutada
    }
    

    public function update(){
        date_default_timezone_set('America/Managua'); 
        $this->created_at = date("Y-m-d H:i:s");
        $sql = "UPDATE " . self::$tablename . " SET product_id=?, q=? WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isi", $this->product_id, $this->q, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function updateOperation(){
        date_default_timezone_set('America/Managua'); 
        $this->created_at = date("Y-m-d H:i:s");
        $sql = "UPDATE " . self::$tablename . " SET operation_type_id=?, reason_for_return=?, created_at = ? WHERE id=?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issi", $this->operation_type_id, $this->reason_for_return, $this->created_at, $this->id);
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
        return Model::one($result, new OperationData());
    }

    
    public function addDiscard(){
        $sql = "INSERT INTO " . self::$tablename . " (product_id, reason, q, operation_type_id, sell_id, created_at, new_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issiisd", $this->product_id, $this->reason, $this->q, $this->operation_type_id, $this->sell_id, $this->created_at, $this->new_price);
        $stmt->execute();
        return array($stmt, $con->insert_id);
    }

    public static function getAllByDateOp($start, $end, $op) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE DATE(created_at) >= \"$start\" AND DATE(created_at) <= \"$end\" AND operation_type_id = $op ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new OperationData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM " . self::$tablename;
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllByDateOfficial($start, $end){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE date(created_at) >= ? AND date(created_at) <= ? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $start, $end);
        if ($start == $end) {
            $sql = "SELECT * FROM " . self::$tablename . " WHERE date(created_at) = ? ORDER BY created_at DESC";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $start);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllByDateOfficialBP($product, $start, $end){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE date(created_at) >= ? AND date(created_at) <= ? AND product_id=? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $start, $end, $product);
        if ($start == $end) {
            $sql = "SELECT * FROM " . self::$tablename . " WHERE date(created_at) = ? AND product_id=? ORDER BY created_at DESC";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $start, $product);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData()); 
    }

    public function getProduct(){ 
        return ProductData::getById($this->product_id); 
    }

    public function getOperationtype(){  
        return OperationTypeData::getById($this->operation_type_id); 
    } 

    public static function getQYesF($product_id){
        $q = 0;
        $operations = self::getAllByProductId($product_id);
        $input_id = OperationTypeData::getByName("Compra")->id;
        $output_id = OperationTypeData::getByName("Venta")->id;
        $discard_id = OperationTypeData::getByName("Desecho")->id;
        
        foreach ($operations as $operation) {
            if ($operation->operation_type_id == $input_id) {  
                $q += $operation->q; 
            } else if ($operation->operation_type_id == $output_id) {   
                $q += (-$operation->q);
            }else if ($operation->operation_type_id == $discard_id) {   
                $q += (-$operation->q);
            }
        }
        return $q;
    }
 
    public static function getAllByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllByProductId($product_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllByProductIdCutIdOficial($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllProductsBySellId($sell_id, $filtro = 4){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE sell_id=? and operation_type_id != ? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $sell_id, $filtro);                                                                         
        $stmt->execute();                     
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getAllByProductIdCutIdYesF($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getOutputQ($product_id, $cut_id){
        $q = 0;
        $operations = self::getOutputByProductIdCutId($product_id, $cut_id);
        $input_id = OperationTypeData::getByName("Compra")->id;
        $output_id = OperationTypeData::getByName("Venta ")->id;
        foreach ($operations as $operation) {
            if ($operation->operation_type_id == $input_id) { 
                $q += $operation->q; 
            } else if ($operation->operation_type_id == $output_id) {  
                $q += (-$operation->q); 
            }
        }
        return $q;
    }

    public static function getOutputQYesF($product_id){
        $q = 0;
        $operations = self::getOutputByProductId($product_id);
        $input_id = OperationTypeData::getByName("Compra")->id;
        $output_id = OperationTypeData::getByName("Venta ")->id;
        foreach ($operations as $operation) {
            if ($operation->operation_type_id == $input_id) { 
                $q += $operation->q; 
            } else if ($operation->operation_type_id == $output_id) {  
                $q += (-$operation->q); 
            }
        }
        return $q;
    }

    public static function getInputQYesF($product_id){
        $q = 0;
        $operations = self::getInputByProductId($product_id);
        $input_id = OperationTypeData::getByName("Compra")->id;
        foreach ($operations as $operation) {
            if ($operation->operation_type_id == $input_id) { 
                $q += $operation->q; 
            }
        }
        return $q;
    }

    public static function getOutputByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? AND operation_type_id=2 ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getOutputByProductId($product_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND operation_type_id=2 ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getInputQ($product_id, $cut_id){
        $q = 0;
        $operations = self::getInputByProductId($product_id);
        $input_id = OperationTypeData::getByName("Compra")->id;
        $output_id = OperationTypeData::getByName("Venta ")->id;
        foreach ($operations as $operation) {
            if ($operation->operation_type_id == $input_id) { 
                $q += $operation->q; 
            } else if ($operation->operation_type_id == $output_id) {  
                $q += (-$operation->q); 
            }
        }
        return $q;
    }

    public static function getInputByProductIdCutId($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? AND operation_type_id=1 ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getInputByProductId($product_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND operation_type_id=1 ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }

    public static function getInputByProductIdCutIdYesF($product_id, $cut_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE product_id=? AND cut_id=? AND operation_type_id=1 ORDER BY created_at DESC";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $product_id, $cut_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new OperationData());
    }
}

?>