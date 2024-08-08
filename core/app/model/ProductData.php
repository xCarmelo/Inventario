<?php
class ProductData {
    public static $tablename = "product";

    public function __construct() {
        $this->name = "";
        $this->price_in = "";
        $this->price_out = "";
        $this->unit = "";
        $this->user_id = "";
        $this->presentation = "0";
        $this->created_at = "NOW()";
    }

    public function getCategory() {
        return CategoryData::getById($this->category_id);
    }

public function add() {
    $con = Database::getCon();
    $stmt = $con->prepare("INSERT INTO " . self::$tablename . " (barcode, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssdisdii", $this->barcode, $this->name, $this->description, $this->price_in, $this->price_out, $this->user_id, $this->presentation, $this->unit, $this->category_id, $this->inventary_min);

    if ($stmt->execute()) {
        header("Location: index.php?view=addproduct&result=success");
    } else {
        header("Location: index.php?view=addproduct&result=error");
    }
    $stmt->close();
    exit(); // Asegurarse de que el script se detiene después de redirigir
}

    

    public function add_with_image() {
        $con = Database::getCon();
        $stmt = $con->prepare("INSERT INTO " . self::$tablename . " (barcode, image, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdisdiis", $this->barcode, $this->image, $this->name, $this->description, $this->price_in, $this->price_out, $this->user_id, $this->presentation, $this->unit, $this->category_id, $this->inventary_min);
        $stmt->execute();
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
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET barcode = ?, name = ?, price_in = ?, price_out = ?, unit = ?, presentation = ?, category_id = ?, inventary_min = ?, description = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssssdisiisi", $this->barcode, $this->name, $this->price_in, $this->price_out, $this->unit, $this->presentation, $this->category_id, $this->inventary_min, $this->description, $this->is_active, $this->id);
        
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
        $stmt->execute();
    }

    public function update_image() {
        $con = Database::getCon();
        $stmt = $con->prepare("UPDATE " . self::$tablename . " SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $this->image, $this->id);
        $stmt->execute();
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
