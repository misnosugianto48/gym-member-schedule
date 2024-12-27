<?php
require_once '../../../controllers/admin/BookingController.php';

if (isset($_GET['id'])) {
  $bookingController = new BookingController();
  $result = $bookingController->updateBookingStatus($_GET['id'], 'COMPLETED');

  $_SESSION['alert'] = [
    'type' => $result['status'],
    'message' => $result['message']
  ];
}

header('Location: ../bookings.php');
exit();
