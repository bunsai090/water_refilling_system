<?php
class Customer {
    private $conn;
    private $table = 'customers';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all customers
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get customer by ID
    public function getById($customer_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Generate unique customer code
    private function generateCustomerCode() {
        $query = "SELECT MAX(customer_id) as max_id FROM " . $this->table;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        $next_id = ($row['max_id'] ?? 0) + 1;
        return 'CUST-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
    }
    
    // Create new customer
    public function create($full_name, $address = null, $phone = null, $email = null) {
        $customer_code = $this->generateCustomerCode();
        
        $query = "INSERT INTO " . $this->table . " (customer_code, full_name, address, phone, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $customer_code, $full_name, $address, $phone, $email);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }
    
    // Update customer
    public function update($customer_id, $full_name, $address = null, $phone = null, $email = null) {
        $query = "UPDATE " . $this->table . " SET full_name = ?, address = ?, phone = ?, email = ? WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $full_name, $address, $phone, $email, $customer_id);
        return $stmt->execute();
    }
    
    // Delete customer
    public function delete($customer_id) {
        $query = "DELETE FROM " . $this->table . " WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $customer_id);
        return $stmt->execute();
    }
    
    // Get customer statistics
    public function getStatistics($customer_id) {
        $query = "SELECT * FROM customer_statistics WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
