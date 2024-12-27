
<?php
class ScheduleController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }
  public function getAvailableSchedules()
  {
    $conn = $this->db->connect();
    $query = "SELECT s.*, m.fullname as mentor_name, m.specialization 
                 FROM schedules s
                 JOIN mentors m ON s.mentor_id = m.id
                 WHERE s.status = 'SCHEDULED' 
                 AND s.remaining < s.quota
                 AND s.date >= CURRENT_DATE
                 ORDER BY s.date, s.start_at";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getMySchedules($userId)
  {
    $conn = $this->db->connect();
    $query = "SELECT b.*, 
                 s.date, s.start_at, s.end_at, s.status,
                 m.fullname as mentor_name, m.specialization
                 FROM bookings b
                 JOIN schedules s ON b.schedule_id = s.id
                 JOIN mentors m ON b.mentor_id = m.id
                 JOIN orders o ON b.order_id = o.id
                 JOIN members mb ON o.member_id = mb.id
                 WHERE mb.user_id = :user_id
                 ORDER BY s.date, s.start_at";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createBooking($scheduleId, $userId)
  {
    $conn = $this->db->connect();

    try {
      $conn->beginTransaction();

      // Get member_id and active order
      $query = "SELECT o.id as order_id, s.mentor_id 
                 FROM orders o 
                 JOIN members m ON o.member_id = m.id
                 JOIN schedules s ON s.id = :schedule_id
                 WHERE m.user_id = :user_id 
                 AND o.status = 'PAID'
                 LIMIT 1";

      $stmt = $conn->prepare($query);
      $stmt->bindParam(':schedule_id', $scheduleId);
      $stmt->bindParam(':user_id', $userId);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        return [
          'status' => 'error',
          'message' => 'No active membership found'
        ];
      }

      // Create booking
      $bookingId = 'BK' . date('YmdHis');
      $insertQuery = "INSERT INTO bookings (id, order_id, schedule_id, mentor_id) 
                       VALUES (:id, :order_id, :schedule_id, :mentor_id)";

      $stmt = $conn->prepare($insertQuery);
      $stmt->bindParam(':id', $bookingId);
      $stmt->bindParam(':order_id', $data['order_id']);
      $stmt->bindParam(':schedule_id', $scheduleId);
      $stmt->bindParam(':mentor_id', $data['mentor_id']);
      $stmt->execute();

      // Update remaining slots
      $updateQuery = "UPDATE schedules 
                       SET remaining = remaining + 1 
                       WHERE id = :schedule_id";

      $stmt = $conn->prepare($updateQuery);
      $stmt->bindParam(':schedule_id', $scheduleId);
      $stmt->execute();

      $conn->commit();

      return [
        'status' => 'success',
        'message' => 'Schedule booked successfully'
      ];
    } catch (PDOException $e) {
      $conn->rollBack();
      return [
        'status' => 'error',
        'message' => 'Booking failed: ' . $e->getMessage()
      ];
    }
  }
}
