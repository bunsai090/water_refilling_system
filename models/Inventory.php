<?php
class Inventory {
    private $conn;
    private $table = 'inventory';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all inventory items
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY item_type, item_name";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get inventory by ID
    public function getById($inventory_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $inventory_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Get inventory by type
    public function getByType($item_type) {
        $query = "SELECT * FROM " . $this->table . " WHERE item_type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $item_type);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Create inventory item
    public function create($item_name, $item_type, $quantity, $unit, $price, $min_stock_level = 10) {
        $query = "INSERT INTO " . $this->table . " (item_name, item_type, quantity, unit, price, min_stock_level) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssissi", $item_name, $item_type, $quantity, $unit, $price, $min_stock_level);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }
    
    // Update inventory item
    public function update($inventory_id, $item_name, $quantity, $unit, $price, $min_stock_level) {
        $query = "UPDATE " . $this->table . " 
                  SET item_name = ?, quantity = ?, unit = ?, price = ?, min_stock_level = ? 
                  WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissii", $item_name, $quantity, $unit, $price, $min_stock_level, $inventory_id);
        return $stmt->execute();
    }
    
    // Add stock
    public function addStock($inventory_id, $quantity, $created_by, $notes = null) {
        // Update inventory quantity
        $query = "UPDATE " . $this->table . " SET quantity = quantity + ? WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $quantity, $inventory_id);
        
        if ($stmt->execute()) {
            // Log transaction
            $this->logTransaction($inventory_id, 'Stock In', $quantity, 'Manual', null, $notes, $created_by);
            return true;
        }
        return false;
    }
    
    // Remove stock
    public function removeStock($inventory_id, $quantity, $created_by, $reference_id = null, $notes = null) {
        // Update inventory quantity
        $query = "UPDATE " . $this->table . " SET quantity = quantity - ? WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $quantity, $inventory_id);
        
        if ($stmt->execute()) {
            // Log transaction
            $reference_type = $reference_id ? 'Order' : 'Manual';
            $this->logTransaction($inventory_id, 'Stock Out', $quantity, $reference_type, $reference_id, $notes, $created_by);
            return true;
        }
        return false;
    }
    
    // Log inventory transaction
    private function logTransaction($inventory_id, $transaction_type, $quantity, $reference_type, $reference_id, $notes, $created_by) {
        $query = "INSERT INTO inventory_transactions (inventory_id, transaction_type, quantity, reference_type, reference_id, notes, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isisisi", $inventory_id, $transaction_type, $quantity, $reference_type, $reference_id, $notes, $created_by);
        $stmt->execute();
    }
    
    // Get transaction history
    public function getTransactions($inventory_id = null) {
        if ($inventory_id) {
            $query = "SELECT t.*, i.item_name, u.full_name as created_by_name 
                      FROM inventory_transactions t 
                      LEFT JOIN " . $this->table . " i ON t.inventory_id = i.inventory_id 
                      LEFT JOIN users u ON t.created_by = u.user_id 
                      WHERE t.inventory_id = ? 
                      ORDER BY t.transaction_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $inventory_id);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $query = "SELECT t.*, i.item_name, u.full_name as created_by_name 
                      FROM inventory_transactions t 
                      LEFT JOIN " . $this->table . " i ON t.inventory_id = i.inventory_id 
                      LEFT JOIN users u ON t.created_by = u.user_id 
                      ORDER BY t.transaction_date DESC 
                      LIMIT 100";
            $result = $this->conn->query($query);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Delete inventory item
    public function delete($inventory_id) {
        $query = "DELETE FROM " . $this->table . " WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $inventory_id);
        return $stmt->execute();
    }
    
    // Get inventory summary
    public function getSummary() {
        $query = "SELECT 
                    SUM(CASE WHEN item_type = 'Full Bottle' THEN quantity ELSE 0 END) as full_bottles,
                    SUM(CASE WHEN item_type = 'Empty Bottle' THEN quantity ELSE 0 END) as empty_bottles,
                    SUM(CASE WHEN item_type = 'Water Stock' THEN quantity ELSE 0 END) as water_stock,
                    COUNT(CASE WHEN status = 'Low Stock' OR status = 'Out of Stock' THEN 1 END) as low_stock_items
                  FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
}
?>
