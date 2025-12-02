<?php
class Order {
    private $conn;
    private $table = 'orders';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all orders with customer names
    public function getAll() {
        $query = "SELECT o.*, c.full_name as customer_name 
                  FROM " . $this->table . " o 
                  LEFT JOIN customers c ON o.customer_id = c.customer_id 
                  ORDER BY o.order_date DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get order by ID
    public function getById($order_id) {
        $query = "SELECT o.*, c.full_name as customer_name, c.phone as customer_phone, c.address as customer_address
                  FROM " . $this->table . " o 
                  LEFT JOIN customers c ON o.customer_id = c.customer_id 
                  WHERE o.order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Generate unique order code
    private function generateOrderCode() {
        $query = "SELECT MAX(order_id) as max_id FROM " . $this->table;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        $next_id = ($row['max_id'] ?? 0) + 1;
        return 'ORD-' . str_pad($next_id, 4, '0', STR_PAD_LEFT);
    }
    
    // Create new order
    public function create($customer_id, $order_type, $quantity, $unit_price, $created_by, $notes = null) {
        $order_code = $this->generateOrderCode();
        $total_amount = $quantity * $unit_price;
        
        $query = "INSERT INTO " . $this->table . " (order_code, customer_id, order_type, quantity, unit_price, total_amount, created_by, notes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiddis", $order_code, $customer_id, $order_type, $quantity, $unit_price, $total_amount, $created_by, $notes);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }
    
    // Update order status
    public function updateStatus($order_id, $order_status, $payment_status = null) {
        if ($payment_status !== null) {
            $query = "UPDATE " . $this->table . " SET order_status = ?, payment_status = ? WHERE order_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $order_status, $payment_status, $order_id);
        } else {
            $query = "UPDATE " . $this->table . " SET order_status = ? WHERE order_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $order_status, $order_id);
        }
        
        // If order is completed, set completed_date
        if ($order_status === 'Completed') {
            $query = "UPDATE " . $this->table . " SET order_status = ?, completed_date = CURRENT_TIMESTAMP WHERE order_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $order_status, $order_id);
        }
        
        return $stmt->execute();
    }
    
    // Update order
    public function update($order_id, $customer_id, $order_type, $quantity, $unit_price, $order_status, $payment_status, $notes = null) {
        $total_amount = $quantity * $unit_price;
        
        $query = "UPDATE " . $this->table . " 
                  SET customer_id = ?, order_type = ?, quantity = ?, unit_price = ?, total_amount = ?, 
                      order_status = ?, payment_status = ?, notes = ? 
                  WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isiddssi", $customer_id, $order_type, $quantity, $unit_price, $total_amount, $order_status, $payment_status, $notes, $order_id);
        return $stmt->execute();
    }
    
    // Delete order
    public function delete($order_id) {
        $query = "DELETE FROM " . $this->table . " WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        return $stmt->execute();
    }
    
    // Get today's statistics
    public function getTodayStats() {
        $query = "SELECT 
                    COUNT(*) as total_orders,
                    SUM(CASE WHEN order_status = 'Pending' THEN 1 ELSE 0 END) as pending_orders,
                    SUM(CASE WHEN order_status = 'Completed' THEN 1 ELSE 0 END) as completed_orders,
                    SUM(CASE WHEN payment_status = 'Paid' THEN total_amount ELSE 0 END) as total_sales
                  FROM " . $this->table . " 
                  WHERE DATE(order_date) = CURDATE()";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
}
?>
