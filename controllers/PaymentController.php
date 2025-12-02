<?php
require_once '../config/database.php';
require_once '../models/Payment.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$conn = getDBConnection();
$paymentModel = new Payment($conn);

$action = $_POST['action'] ?? '';

if ($action == 'create') {
    $order_id = $_POST['order_id'];
    $customer_id = $_POST['customer_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $reference_number = $_POST['reference_number'] ?? null;
    $notes = $_POST['notes'] ?? null;
    $processed_by = $_SESSION['user_id'];
    
    if ($paymentModel->create($order_id, $customer_id, $amount, $payment_method, $processed_by, $reference_number, $notes)) {
        header('Location: ../dashboard/payments.php?success=created');
    } else {
        header('Location: ../dashboard/payments.php?error=create_failed');
    }
    exit();
}

header('Location: ../dashboard/payments.php');
exit();
?>
