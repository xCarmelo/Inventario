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
        $con = Database::getCon();

        // 1. Validar datos antes de la inserción
        $errors = $this->validate(); 
    
        // 1. Validar datos antes de la inserción (opcional pero recomendado)
        // Aquí puedes agregar validaciones para asegurarte de que los datos sean correctos
        // antes de intentar insertarlos en la base de datos.
    
        $stmt = $con->prepare(
            "INSERT INTO " . self::$tablename . " 
            (barcode, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" // Nota: se cambió $this->created_at por ?
        );
    
        if (!$stmt) { // Verificar si la preparación de la sentencia falló
            throw new Exception("Error al preparar la sentencia: " . $con->error);
        }
    
        $category_id = $this->category_id ?? null;
        $inventary_min = $this->inventary_min ?? null;
        $created_at = date("Y-m-d H:i:s"); // Obtener la fecha y hora actual
    
        $stmt->bind_param("sssddissiis", 
            $this->barcode, $this->name, $this->description, $this->price_in, 
            $this->price_out, $this->user_id, $this->presentation, $this->unit, 
            $category_id, $inventary_min, $created_at
        );
    
        if ($stmt->execute()) {
            header("Location: index.php?view=products&success=Producto agregado exitosamente"); 
        } else {
            error_log("Error adding product: " . $stmt->error);
            header("Location: index.php?view=products&error=Error al agregar el producto. Verifica los datos e inténtalo de nuevo."); 
        }
    
        $stmt->close();
        exit();
    }

    public function add_with_image() {
        $con = Database::getCon();
        $stmt = $con->prepare(
            "INSERT INTO " . self::$tablename . " 
            (barcode, image, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, $this->created_at)"
        );

        $category_id = $this->category_id ?? null;
        $inventary_min = $this->inventary_min ?? null;

        $stmt->bind_param("ssssddissii", 
            $this->barcode, $this->image, $this->name, $this->description, 
            $this->price_in, $this->price_out, $this->user_id, $this->presentation, 
            $this->unit, $category_id, $inventary_min
        );

        if ($stmt->execute()) {
            header("Location: index.php?view=products");
        } else {
            error_log("Error adding product with image: " . $stmt->error);
            header("Location: index.php?view=addproduct&result=error");
        }

        $stmt->close();
        exit();
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

    public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

    public function update() {
            $con = Database::getCon();
            $stmt = $con->prepare(
                "UPDATE " . self::$tablename . " 
                SET barcode = ?, name = ?, price_in = ?, price_out = ?, unit = ?, 
                presentation = ?, category_id = ?, inventary_min = ?, 
                description = ?, is_active = ? WHERE id = ?"
            );
            $stmt->bind_param("ssddssiisii", 
                $this->barcode, $this->name, $this->price_in, $this->price_out, 
                $this->unit, $this->presentation, $this->category_id, 
                $this->inventary_min, $this->description, $this->is_active, $this->id
            );

            if (!$stmt->execute()) {
                error_log("Error updating product: " . $stmt->error);
                echo "<script>console.error('Error updating product: " . $stmt->error . "');</script>";
            } else {
                echo "<script>console.log('Product updated successfully');</script>";
            }

            $stmt->close();
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
        if (!$stmt->execute()) {
            error_log("Error updating product image: " . $stmt->error);
        }
        $stmt->close();
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
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE barcode LIKE ? OR name LIKE ? OR id LIKE ?");
        $like = "%$p%";
        $stmt->bind_param("sss", $like, $like, $like);
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
