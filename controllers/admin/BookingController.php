<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class BookingController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getBookings()
  {
    $conn = $this->db->connect();
    $query = "SELECT b.*, 
                 s.date, s.start_at, s.end_at, s.status as schedule_status,
                 m.fullname as mentor_name, m.specialization,
                 mb.fullname as member_name
                 FROM bookings b
                 JOIN schedules s ON b.schedule_id = s.id
                 JOIN mentors m ON b.mentor_id = m.id
                 JOIN orders o ON b.order_id = o.id
                 JOIN members mb ON o.member_id = mb.id
                 ORDER BY s.date DESC, s.start_at ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateBookingStatus($bookingId, $status)
  {
    $conn = $this->db->connect();
    $query = "UPDATE schedules s 
                 JOIN bookings b ON s.id = b.schedule_id
                 SET s.status = :status 
                 WHERE b.id = :booking_id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':booking_id', $bookingId);
      $stmt->execute();

      return [
        'status' => 'success',
        'message' => 'Booking status updated successfully'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Failed to update booking status'
      ];
    }
  }
}
