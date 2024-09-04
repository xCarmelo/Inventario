<?php
class UserData {
    public static $tablename = "user";

    public function __construct() {
        $this->id = null; // Asumiendo que 'id' es autoincremental en la base de datos
        $this->name = "";
        $this->lastname = "";
        $this->email = "";
        $this->username = "";
        $this->password = "";
        $this->image = null; // O asigna un valor predeterminado si es necesario
        $this->is_active = 1; // Valor predeterminado
        $this->is_admin = 0;
        date_default_timezone_set('America/Managua'); 
        $this->created_at = date("Y-m-d H:i:s");
    }
    // Método para agregar un nuevo usuario con una consulta preparada

    public function add() {
        $sql = "INSERT INTO user (name, lastname, username, email, is_admin, password, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Obtén la conexión a la base de datos
        $con = Database::getCon(); // Asumiendo que `Database::getConnection()` devuelve la conexión
        
        // Prepara la consulta
        $stmt = $con->prepare($sql);
        
        // Vincula los parámetros
        $stmt->bind_param("ssssiss", 
            $this->name, 
            $this->lastname, 
            $this->username, 
            $this->email, 
            $this->is_admin, 
            $this->password, 
            $this->created_at
        );
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Cierra la consulta
        $stmt->close();
    }
    
    public static function delById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function del() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET name = ?, email = ?, username = ?, lastname = ?, is_active = ?, is_admin = ? 
                WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssiii", 
            $this->name, 
            $this->email, 
            $this->username, 
            $this->lastname, 
            $this->is_active, 
            $this->is_admin, 
            $this->id
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update_passwd() {
        $sql = "UPDATE " . self::$tablename . " SET password = ? WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $this->password, $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = Model::one($result, new UserData());
        $stmt->close();
        return $data;
    }

    public static function getByMail($mail) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE email = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = Model::one($result, new UserData());
        $stmt->close();
        return $data;
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $con = Database::getCon();
        $result = $con->query($sql);
        return Model::many($result, new UserData());
    }

    public static function getLike($q) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name LIKE ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $likeQuery = "%" . $q . "%";
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = Model::many($result, new UserData());
        $stmt->close();
        return $data;
    }
}

?>