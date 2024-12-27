<?php
require_once '../../../controllers/admin/OrderController.php';

if (isset($_GET['id'])) {
  $orderController = new OrderController();
  $result = $orderController->confirmPayment($_GET['id']);

  $_SESSION['alert'] = [
    'type' => $result['status'],
    'message' => $result['message']
  ];
}

header('Location: ../orders.php');
exit();
