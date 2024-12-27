
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class PaymentController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function uploadPaymentProof($orderId, $file)
  {
    if ($file['error'] !== UPLOAD_ERR_OK) {
      return [
        'status' => 'error',
        'message' => 'File upload failed'
      ];
    }

    $conn = $this->db->connect();

    try {
      $conn->beginTransaction();

      $imageData = file_get_contents($file['tmp_name']);

      $query = "UPDATE orders 
                 SET payment_proof = :proof,
                     updated_at = CURRENT_TIMESTAMP 
                 WHERE id = :order_id";

      $stmt = $conn->prepare($query);
      $stmt->bindParam(':proof', $imageData, PDO::PARAM_LOB);
      $stmt->bindParam(':order_id', $orderId);
      $stmt->execute();

      $conn->commit();

      return [
        'status' => 'success',
        'message' => 'Payment proof uploaded successfully'
      ];
    } catch (PDOException $e) {
      $conn->rollBack();
      return [
        'status' => 'error',
        'message' => 'Upload failed: ' . $e->getMessage()
      ];
    }
  }

  public function getPendingPayments($userId)
  {
    $conn = $this->db->connect();
    $query = "SELECT o.*, m.name as membership_name, m.duration, m.price 
                 FROM orders o
                 JOIN memberships m ON o.membership_id = m.id
                 JOIN members mb ON o.member_id = mb.id
                 WHERE mb.user_id = :user_id 
                 AND o.status = 'PENDING'
                 ORDER BY o.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getPaymentHistory($userId)
  {
    $conn = $this->db->connect();
    $query = "SELECT o.*, m.name as membership_name, m.duration, m.price 
                 FROM orders o
                 JOIN memberships m ON o.membership_id = m.id
                 JOIN members mb ON o.member_id = mb.id
                 WHERE mb.user_id = :user_id 
                 AND o.status IN ('PAID', 'FAILED')
                 ORDER BY o.updated_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
