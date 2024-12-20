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
    $query = "SELECT orders.id, orders.total, orders.method, orders.status, members.fullname, memberships.name as memberships FROM orders INNER JOIN members ON members.id = orders.member_id INNER JOIN memberships ON memberships.id = orders.member_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $memberships;
  }

  public function getMembershipById($id)
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM memberships WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(
      ':id',
      $id
    );
    $stmt->execute();
    $membership = $stmt->fetch(PDO::FETCH_ASSOC);
    return $membership;
  }

  private function generateId()
  {
    $conn = $this->db->connect();
    $query = "SELECT id FROM memberships ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'OD' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'OD001';
  }

  public function store($data)
  {
    $conn = $this->db->connect();
    $id = $this->generateId();

    $query = "INSERT INTO memberships (id, name, duration, price, description) VALUES (:id, :name, :duration, :price, :description)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':duration', $data['duration']);
      $stmt->bindParam(':price', $data['price']);
      $stmt->bindParam(':description', $data['description']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../../admin/memberships.php',
        'message' => 'Memberships created successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Memberships created failed: ' . $e->getMessage()
      ];
    }
  }

  public function update($id, $data)
  {
    $conn = $this->db->connect();
    $query = "UPDATE memberships SET name = :name, duration = :duration, price = :price, description = :description, is_active = :is_active WHERE id = :id";
    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':duration', $data['duration']);
      $stmt->bindParam(':price', $data['price']);
      $stmt->bindParam(':description', $data['description']);
      $stmt->bindParam(':is_active', $data['is_active']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../memberships.php',
        'message' => 'Membership updated successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Membership updated failed: ' . $e->getMessage()
      ];
    }
  }

  public function destroy($id)
  {
    $conn = $this->db->connect();
    $query = "DELETE FROM memberships WHERE id = :id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return [
        'status' => 'success',
        'redirect' => '../../admin/memberships.php',
        'message' => 'Membership deleted successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Membership deleted failed: ' . $e->getMessage()
      ];
    }
  }
}
