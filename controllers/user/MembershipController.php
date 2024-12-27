<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class MembershipController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getActiveMembership($userId)
  {
    $conn = $this->db->connect();
    $query = "SELECT o.*, m.name as membership_name, m.duration, m.price, m.description 
                FROM orders o
                JOIN memberships m ON o.membership_id = m.id
                JOIN members mb ON o.member_id = mb.id
                WHERE mb.user_id = :user_id 
                AND o.status = 'PAID'
                AND m.is_active = 1
                ORDER BY o.created_at DESC
                LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAllMemberships()
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM memberships WHERE is_active = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createOrder($data)
  {
    $conn = $this->db->connect();
    $query = "INSERT INTO orders (id, member_id, membership_id, total, method, status) 
              VALUES (:id, :member_id, :membership_id, :total, :method, :status)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $data['id']);
      $stmt->bindParam(':member_id', $data['member_id']);
      $stmt->bindParam(':membership_id', $data['membership_id']);
      $stmt->bindParam(':total', $data['total']);
      $stmt->bindParam(':method', $data['method']);
      $stmt->bindParam(':status', $data['status']);
      $stmt->execute();

      return [
        'status' => 'success',
        'message' => 'Order created successfully'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Order creation failed: ' . $e->getMessage()
      ];
    }
  }
}
