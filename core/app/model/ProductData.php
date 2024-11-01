<?php
class ProductData {
    public static $tablename = "product";

    public function __construct() { 
        $this->name = "";
        $this->price_in = 0.0;
        $this->price_out = 0.0;
        $this->unit = "";
        $this->user_id = 0; 
        $this->presentation = "";
        $this->description = "";
        // Establecer la zona horaria deseada (reemplaza 'America/Managua' con tu zona horaria)
        date_default_timezone_set('America/Managua'); 
    
        $this->created_at = date("Y-m-d H:i:s");  
    }

    public function validate() {
        $errors = [];
    
        // Validar que el nombre no esté vacío
        if (empty($this->name)) {
            $errors[] = "El nombre es obligatorio.";
        }
    
        // Validar que los precios sean numéricos y mayores que cero
        if (!is_numeric($this->price_in) || $this->price_in <= 0) {
            $errors[] = "El precio de entrada debe ser un número mayor que cero.";
        }
        if (!is_numeric($this->price_out) || $this->price_out <= 0) {
            $errors[] = "El precio de salida debe ser un número mayor que cero.";
        }
    
        // Otras validaciones que consideres necesarias...
    
        return $errors;
    }

    public function getCategory() {
        return CategoryData::getById($this->category_id);
    }

    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " 
                (name, description, price_in, price_out, user_id, presentation, category_id, inventary_min, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        
        $stmt->bind_param("ssddisiis", 
            $this->name, $this->description, $this->price_in, $this->price_out, 
            $this->user_id, $this->presentation, $this->category_id, $this->inventary_min, 
            $this->created_at
        );
        
        $stmt->execute();
        return $stmt;
    }


    public function add_with_image() { 
        $sql = "INSERT INTO " . self::$tablename . " 
                (image, name, description, price_in, price_out, user_id, presentation, category_id, inventary_min, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
    
        if ($stmt === false) {
            die("Error en la preparación de la consulta");
        }
    
        // Asignar valores nulos si no están definidos
        $category_id = $this->category_id ?? null;
        $inventary_min = $this->inventary_min ?? null;
        $created_at = date("Y-m-d H:i:s"); // Obtener la fecha y hora actual
    
        // Asignar parámetros a la consulta
        $stmt->bind_param("sssddisiis", 
            $this->image, $this->name, $this->description, 
            $this->price_in, $this->price_out, $this->user_id, $this->presentation, 
            $category_id, $inventary_min, $created_at
        );
    
        $stmt->execute();

        return $stmt;
    }


    public static function delById($id) {
        $con = Database::getCon();
        $stmt = $con->prepare("DELETE FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Error deleting product by id: " . $stmt->error);
        }
        $stmt->close();
    }

    public function del($active = 0) { 
        $con = Database::getCon(); // Obtiene la conexión a la base de datos
        $sql = "UPDATE " . self::$tablename . " SET is_active = ? WHERE id=?";
        $stmt = $con->prepare($sql); // Prepara la consulta SQL
        
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta"); // Lanza una excepción si hay un error
        }
        
        $stmt->bind_param("ii", $active, $this->id); // Asocia el parámetro ID
        
        if (!$stmt->execute()) { // Ejecuta la consulta y verifica si hubo un error
            throw new Exception("Error al eliminar el registro");
        }
        
        return $stmt; // Devuelve la declaración ejecutada
    }

    public function update() {
            $con = Database::getCon();
            $stmt = $con->prepare(
                "UPDATE " . self::$tablename . " 
                SET name = ?, price_in = ?, price_out = ?, 
                presentation = ?, category_id = ?, inventary_min = ?, 
                description = ?, is_active = ? WHERE id = ?"
            );
            $stmt->bind_param("sddsiisii", 
                $this->name, $this->price_in, $this->price_out, 
                $this->presentation, $this->category_id, 
                $this->inventary_min, $this->description, $this->is_active, $this->id
            );

            return $stmt->execute();

        }

    
    public function del_category() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET category_id = NULL WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        if (!$stmt->execute()) {
            error_log("Error removing product category: " . $stmt->error);
        }
        $stmt->close();
    }

    public function update_image() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $this->image, $this->id);
        return $stmt->execute();
    }

    public static function getById($id) { 
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::one($result, new ProductData());
    }

    public static function getAll() {
        $con = Database::getCon();
        $result = $con->query("SELECT * FROM " . self::$tablename);
        return Model::many($result, new ProductData());
    }

    public static function getAllByPage($start_from, $limit) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE id >= ? LIMIT ?");
        $stmt->bind_param("ii", $start_from, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new ProductData());
    }

    public static function getLike($p) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE  name LIKE ?");
        $like = "%$p%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new ProductData());
    }

    public static function getAllByUserId($user_id) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new ProductData());
    }

    public static function getAllByCategoryId($category_id) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE category_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return Model::many($result, new ProductData());
    }
    
}
?>
