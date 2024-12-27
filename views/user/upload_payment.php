<?php
session_start();
require_once '../../controllers/user/PaymentController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['order_id']) && isset($_FILES['payment_proof'])) {
    $paymentController = new PaymentController();

    $orderId = $_POST['order_id'];
    $file = $_FILES['payment_proof'];

    $result = $paymentController->uploadPaymentProof($orderId, $file);

    $_SESSION['alert'] = [
      'type' => $result['status'],
      'message' => $result['message']
    ];
  }
}

header('Location: payments.php');
exit();
