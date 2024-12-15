<?php
require_once 'model/Database.php';

class RegisterController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  private function generateId()
  {
    $conn = $this->db->connect();
    $query = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'US' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'US001';
  }

  public function register($username, $email, $password, $role, $is_active)
  {
    $conn = $this->db->connect();

    $checkEmail = "SELECT email FROM users WHERE email = :email";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return ['status' => 'error', 'message' => 'Email already exists'];
    }

    $id = $this->generateId();

    $query = "INSERT INTO users (id, username, email, password) 
                 VALUES (:id, :username, :email, :password)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $password);
      // $stmt->bindParam(':role', $role);
      // $stmt->bindParam(':is_active', $is_active);

      $stmt->execute();

      return ['status' => 'success', 'message' => 'Registration successful'];
    } catch (PDOException $e) {
      return ['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()];
    }
  }
}
