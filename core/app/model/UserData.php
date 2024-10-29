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
        $this->phone = "";
        date_default_timezone_set('America/Managua'); 
        $this->created_at = date("Y-m-d H:i:s");
    }
    // Método para agregar un nuevo usuario con una consulta preparada

    public function add() {
        $sql = "INSERT INTO user (name, lastname, username, email, is_admin, password, phone, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Obtén la conexión a la base de datos
        $con = Database::getCon(); 
        
        // Prepara la consulta
        $stmt = $con->prepare($sql);
        
        // Comprueba si la preparación fue exitosa
        if ($stmt === false) {
            die("Error en la preparación de la consulta");
        }
        
        // Vincula los parámetros
        $stmt->bind_param("ssssisss", 
            $this->name, 
            $this->lastname, 
            $this->username, 
            $this->email, 
            $this->is_admin, 
            $this->password, 
            $this->phone,
            $this->created_at
        );
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Retorna el objeto `stmt` para posibles verificaciones posteriores
        return $stmt;
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
        $con = Database::getCon();
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=?";
        $stmt = $con->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
        
        $stmt->bind_param("i", $this->id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar el usuario");
        }
        
        return $stmt;
    }

    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET name = ?, phone = ?, password = ?, email = ?, username = ?, lastname = ?, is_active = ?, is_admin = ? 
                WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssiii", 
            $this->name, 
            $this->phone, 
            $this->password, 
            $this->email, 
            $this->username, 
            $this->lastname, 
            $this->is_active, 
            $this->is_admin, 
            $this->id
        );
        $stmt->execute();

        return $stmt;
    }

    public function desactive_user() {
        $sql = "UPDATE " . self::$tablename . " SET is_active = ? WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
        
        $stmt->bind_param("ii", 
            $this->is_active, 
            $this->id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar el estado de la venta");
        }

        return $stmt;
    }

    public function active_user() {
        $sql = "UPDATE " . self::$tablename . " SET is_active = ? WHERE id = ?";
        $con = Database::getCon();
        $stmt = $con->prepare($sql);
 
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta");
        }
        
        $stmt->bind_param("ii", 
            $this->is_active, 
            $this->id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar el estado de la venta");
        }

        return $stmt;
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

    public static function searchUser($q) {
        $con = Database::getCon();
        $stmt = $con->prepare("SELECT * FROM " . self::$tablename . " WHERE username = ?");
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