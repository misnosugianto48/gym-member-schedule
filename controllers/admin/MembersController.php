<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class MembersController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getMembers()
  {
    $conn = $this->db->connect();
    $query = "SELECT m.*, u.username, u.email, u.is_active, u.role,
                   (SELECT o.status FROM orders o WHERE o.member_id = m.id AND o.status = 'PAID' 
                    ORDER BY o.created_at DESC LIMIT 1) as membership_status
                   FROM members m
                   JOIN users u ON m.user_id = u.id
                   WHERE u.role = 1
                   ORDER BY m.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getMemberDetails($memberId)
  {
    $conn = $this->db->connect();
    $query = "SELECT m.*, u.username, u.email, u.is_active,
                   (SELECT COUNT(*) FROM bookings b 
                    JOIN orders o ON b.order_id = o.id 
                    WHERE o.member_id = m.id) as total_sessions,
                   (SELECT o.status FROM orders o 
                    WHERE o.member_id = m.id AND o.status = 'PAID'
                    ORDER BY o.created_at DESC LIMIT 1) as membership_status
                   FROM members m
                   JOIN users u ON m.user_id = u.id
                   WHERE m.id = :member_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':member_id', $memberId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
