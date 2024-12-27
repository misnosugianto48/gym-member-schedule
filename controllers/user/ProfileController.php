<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class ProfileController
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }

  private function generateId()
  {
    $conn = $this->db->connect();
    $query = "SELECT id FROM members ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'MB' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'MB001';
  }

  public function getProfile($userId)
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM members WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(
      ':user_id',
      $userId,
    );
    $stmt->execute();
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    return $profile ? $profile : [
      'fullname' => '',
      'gender' => '',
      'address' => '',
      'phone' => '',
      'motivation' => ''
    ];
  }

  public function updateProfile($data)
  {
    $conn = $this->db->connect();

    $checkQuery = "SELECT id FROM members WHERE user_id = :user_id";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':user_id', $data['user_id']);
    $checkStmt->execute();
    $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
      $query = "UPDATE members SET 
                 fullname = :fullname,
                 gender = :gender,
                 address = :address, 
                 phone = :phone,
                 motivation = :motivation
                 WHERE user_id = :user_id";
    } else {
      $id = $this->generateId();
      $query = "INSERT INTO members 
                 (id, user_id, fullname, gender, address, phone, motivation) 
                 VALUES 
                 (:id, :user_id, :fullname, :gender, :address, :phone, :motivation)";
    }

    try {
      $stmt = $conn->prepare($query);
      if (!$exists) {
        $stmt->bindParam(':id', $id);
      }
      $stmt->bindParam(':user_id', $data['user_id']);
      $stmt->bindParam(':fullname', $data['fullname']);
      $stmt->bindParam(':gender', $data['gender']);
      $stmt->bindParam(':address', $data['address']);
      $stmt->bindParam(':phone', $data['phone']);
      $stmt->bindParam(':motivation', $data['motivation']);
      $stmt->execute();

      return [
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'redirect' => '../user/dashboard.php'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Profile update failed: ' . $e->getMessage()
      ];
    }
  }
}
