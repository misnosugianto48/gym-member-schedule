<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class OrderController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getOrders()
  {
    $conn = $this->db->connect();
    $query = "SELECT o.*, m.name as membership_name, mb.fullname as member_name
               FROM orders o
               JOIN memberships m ON o.membership_id = m.id 
               JOIN members mb ON o.member_id = mb.id
               ORDER BY o.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function confirmPayment($orderId)
  {
    $conn = $this->db->connect();
    $query = "UPDATE orders SET 
               status = 'PAID',
               updated_at = CURRENT_TIMESTAMP
               WHERE id = :order_id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':order_id', $orderId);
      $stmt->execute();

      return [
        'status' => 'success',
        'message' => 'Payment confirmed successfully'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Failed to confirm payment'
      ];
    }
  }

  public function rejectPayment($orderId)
  {
    $conn = $this->db->connect();
    $query = "UPDATE orders SET 
               status = 'FAILED',
               updated_at = CURRENT_TIMESTAMP
               WHERE id = :order_id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':order_id', $orderId);
      $stmt->execute();

      return [
        'status' => 'success',
        'message' => 'Payment rejected'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Failed to reject payment'
      ];
    }
  }
}
