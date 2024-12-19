<?php
require_once '../../../controllers/admin/MentorController.php';

if (isset($_GET['id'])) {
  $mentorController = new MentorController();
  $result = $mentorController->deleteMentor($_GET['id']);

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
