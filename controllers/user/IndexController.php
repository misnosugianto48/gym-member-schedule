<?php
class IndexController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getUserDashboardData($userId)
  {
    $conn = $this->db->connect();

    // Get active membership
    $membershipQuery = "SELECT m.name, o.created_at, m.duration, 
                          SUBSTRING_INDEX(m.duration, ' ', 1) as duration_value
                          FROM orders o 
                          JOIN memberships m ON o.membership_id = m.id
                          JOIN members mb ON o.member_id = mb.id
                          WHERE mb.user_id = :user_id 
                          AND o.status = 'PAID'
                          ORDER BY o.created_at DESC LIMIT 1";

    $stmt = $conn->prepare($membershipQuery);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $membership = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get upcoming schedules
    $scheduleQuery = "SELECT s.date, s.start_at, s.end_at, m.fullname as mentor_name
                         FROM bookings b
                         JOIN schedules s ON b.schedule_id = s.id
                         JOIN mentors m ON b.mentor_id = m.id
                         JOIN orders o ON b.order_id = o.id
                         JOIN members mb ON o.member_id = mb.id
                         WHERE mb.user_id = :user_id
                         AND s.date >= CURRENT_DATE
                         AND s.status = 'SCHEDULED'
                         ORDER BY s.date, s.start_at
                         LIMIT 5";

    $stmt = $conn->prepare($scheduleQuery);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get recent payments
    $paymentQuery = "SELECT o.*, m.name as membership_name
                        FROM orders o
                        JOIN memberships m ON o.membership_id = m.id
                        JOIN members mb ON o.member_id = mb.id
                        WHERE mb.user_id = :user_id
                        ORDER BY o.created_at DESC
                        LIMIT 5";

    $stmt = $conn->prepare($paymentQuery);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'membership' => $membership,
      'schedules' => $schedules,
      'payments' => $payments
    ];
  }
}
