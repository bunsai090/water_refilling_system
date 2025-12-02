<?php
class User {
    private $conn;
    private $table = 'users';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Authenticate user
    public function authenticate($username, $password) {
        $query = "SELECT user_id, username, password, full_name, email, role FROM " . $this->table . " 
                  WHERE username = ? AND status = 'Active' LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Update last login
                $this->updateLastLogin($user['user_id']);
                
                // Return user data (without password)
                unset($user['password']);
                return $user;
            }
        }
        
        return false;
    }
    
    // Update last login timestamp
    private function updateLastLogin($user_id) {
        $query = "UPDATE " . $this->table . " SET last_login = CURRENT_TIMESTAMP WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
    
    // Get user by ID
    public function getUserById($user_id) {
        $query = "SELECT user_id, username, full_name, email, phone, role, status, created_at FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get all users
    public function getAllUsers() {
        $query = "SELECT user_id, username, full_name, email, phone, role, status, created_at, last_login FROM " . $this->table . " ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Create new user
    public function create($username, $password, $full_name, $email = null, $phone = null, $role = 'Staff') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table . " (username, password, full_name, email, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $username, $hashed_password, $full_name, $email, $phone, $role);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }
    
    // Update user
    public function update($user_id, $full_name, $email = null, $phone = null, $role = null) {
        $query = "UPDATE " . $this->table . " SET full_name = ?, email = ?, phone = ?, role = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $full_name, $email, $phone, $role, $user_id);
        return $stmt->execute();
    }
    
    // Delete user
    public function delete($user_id) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}
?>
