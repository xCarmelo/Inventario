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
        try {
            $con = Database::getCon();
            $stmt = $con->prepare("INSERT INTO " . self::$tablename . " (name, created_at) VALUES (?, ?)");
    
            if ($stmt === false) {
                throw new Exception("Error preparando la consulta");
            }
    
            $stmt->bind_param("ss", $this->name, $this->created_at);
    
            if (!$stmt->execute()) {
                throw new Exception("Error ejecutando la consulta " . "");
            }
    
            $stmt->close();
            return ['success' => true];
    
        } catch (Exception $e) {
            // Devolver el mensaje de error
            return ['success' => false, 'error_msg' => "Error al agregar la categoria"];
        }
    }
    

    public static function delById($id) {
        // 1. Validar el ID
        if (!is_numeric($id) || $id <= 0) {
            // Manejar el error (lanzar una excepción, registrar un mensaje, etc.)
            throw new InvalidArgumentException("ID inválido."); 
        }
    
        $con = Database::getCon();
    
        // 2. Opcional: Verificar si el registro existe (si es necesario)
        $stmt_check = $con->prepare("SELECT id FROM " . self::$tablename . " WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        if ($result->num_rows == 0) {
            throw new Exception("El registro no existe."); 
        }
    
        // 3. Proceder con la eliminación
        $stmt = $con->prepare("DELETE FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        // ... (Manejo de errores de la base de datos si es necesario)
    
        $stmt->close();
        $con->close();
    }

    public function del($is_active = 0) {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " set is_active = ? WHERE id = ?");
        $stmt->bind_param("ii", $is_active, $this->id);
        if (!$stmt->execute()) {
            if($is_active = 0)
                throw new Exception("Error al eliminar la categoría."); 
            else 
                throw new Exception("Error al havilitar la categoría."); 
        }
    }

    public function update() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $this->name, $this->id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => "Error al actualizar la categoria"];
        }
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
            $category->is_active = $r['is_active'];
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

    public static function searchCategory($q) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE name = ?");
        $stmt->bind_param("s", $q);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>
