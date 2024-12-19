<?php
require_once '../../../controllers/admin/MembershipsController.php';

if (isset($_GET['id'])) {
  $membershipController = new MembershipController();
  $result = $membershipController->destroy($_GET['id']);

  if ($result['status'] == 'success') {
    $_SESSION['alert'] = [
      'type' => 'success',
      'message' => $result['message']
    ];
    header('Location: ' . $result['redirect']);
    exit();
  } else {
    $error = $result['message'];
  }
}
