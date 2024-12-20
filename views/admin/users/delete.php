<?php
require_once '../../../controllers/admin/UserController.php';

if (isset($_GET['id'])) {
  $userController = new UserController();
  $result = $userController->destroy($_GET['id']);

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
