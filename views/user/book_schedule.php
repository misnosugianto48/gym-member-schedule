<?php
require_once '../../controllers/LoginController.php';
require_once '../../controllers/user/ScheduleController.php';

$loginController = new LoginController();
$scheduleController = new ScheduleController();

if (!$loginController->isLoggedIn() || !$loginController->isUser()) {
  header('Location: ../../login.php');
  exit();
}

if (isset($_GET['id'])) {
  $result = $scheduleController->createBooking($_GET['id'], $_SESSION['user_id']);

  $_SESSION['alert'] = [
    'type' => $result['status'],
    'message' => $result['message']
  ];
}

header('Location: schedules.php');
exit();
