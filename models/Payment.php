<?php
class Payment {
    private $conn;
    private $table = 'payments';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all payments with order and customer info
    public function getAll() {
        $query = "SELECT p.*, o.order_code, c.full_name as customer_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN orders o ON p.order_id = o.order_id 
                  LEFT JOIN customers c ON p.customer_id = c.customer_id 
                  ORDER BY p.payment_date DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get payment by ID
    public function getById($payment_id) {
        $query = "SELECT p.*, o.order_code, o.total_amount as order_amount, c.full_name as customer_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN orders o ON p.order_id = o.order_id 
                  LEFT JOIN customers c ON p.customer_id = c.customer_id 
                  WHERE p.payment_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $payment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get payments by order
    public function getByOrder($order_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = ? ORDER BY payment_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Generate unique payment code
    private function generatePaymentCode() {
        $query = "SELECT MAX(payment_id) as max_id FROM " . $this->table;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        $next_id = ($row['max_id'] ?? 0) + 1;
        return 'PAY-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
    }
    
    // Create new payment
    public function create($order_id, $customer_id, $amount, $payment_method, $processed_by, $reference_number = null, $notes = null) {
        $payment_code = $this->generatePaymentCode();
        
        $query = "INSERT INTO " . $this->table . " (payment_code, order_id, customer_id, amount, payment_method, reference_number, notes, processed_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siidsssi", $payment_code, $order_id, $customer_id, $amount, $payment_method, $reference_number, $notes, $processed_by);
        
        if ($stmt->execute()) {
            // Update order payment status
            $this->updateOrderPaymentStatus($order_id);
            
            // Update customer total spent
            $this->updateCustomerSpent($customer_id, $amount);
            
            return $this->conn->insert_id;
        }
        return false;
    }
    
    // Update order payment status based on total payments
    private function updateOrderPaymentStatus($order_id) {
        $query = "SELECT o.total_amount, COALESCE(SUM(p.amount), 0) as total_paid 
                  FROM orders o 
                  LEFT JOIN " . $this->table . " p ON o.order_id = p.order_id 
                  WHERE o.order_id = ? 
                  GROUP BY o.order_id, o.total_amount";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $payment_status = 'Unpaid';
        if ($row['total_paid'] >= $row['total_amount']) {
            $payment_status = 'Paid';
        } elseif ($row['total_paid'] > 0) {
            $payment_status = 'Partial';
        }
        
        $update = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($update);
        $stmt->bind_param("si", $payment_status, $order_id);
        $stmt->execute();
    }
    
    // Update customer total spent
    private function updateCustomerSpent($customer_id, $amount) {
        $query = "UPDATE customers SET total_spent = total_spent + ? WHERE customer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("di", $amount, $customer_id);
        $stmt->execute();
    }
    
    // Delete payment
    public function delete($payment_id) {
        // Get payment details before deleting
        $payment = $this->getById($payment_id);
        
        $query = "DELETE FROM " . $this->table . " WHERE payment_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $payment_id);
        
        if ($stmt->execute()) {
            // Update order payment status
            $this->updateOrderPaymentStatus($payment['order_id']);
            
            // Update customer total spent (subtract)
            $this->updateCustomerSpent($payment['customer_id'], -$payment['amount']);
            
            return true;
        }
        return false;
    }
}
?>
