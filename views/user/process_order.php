<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once '../../controllers/user/MembershipController.php';
require_once '../../controllers/user/ProfileController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $membershipController = new MembershipController();
  $profileController = new ProfileController();

  $profile = $profileController->getProfile($_SESSION['user_id']);

  $orderId = 'ORD' . date('YmdHis');
  $data = [
    'id' => $orderId,
    'member_id' => $profile['id'],
    'membership_id' => $_POST['membership_id'],
    'total' => $_POST['price'],
    'method' => 'TRANSFER',
    'status' => 'PENDING'
  ];

  $result = $membershipController->createOrder($data);

  if ($result['status'] == 'success') {
    $_SESSION['alert'] = [
      'type' => 'success',
      'message' => 'Order created successfully'
    ];
    header('Location: payments.php');
  } else {
    $_SESSION['alert'] = [
      'type' => 'error',
      'message' => $result['message']
    ];
    header('Location: memberships.php');
  }
  exit();
}
