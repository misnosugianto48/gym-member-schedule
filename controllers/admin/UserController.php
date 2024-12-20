<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class UserController
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }
  public function getusers()
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $mentors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $mentors;
  }

  public function getUserById($id)
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(
      ':id',
      $id
    );
    $stmt->execute();
    $mentor = $stmt->fetch(PDO::FETCH_ASSOC);
    return $mentor;
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

  private function generateIdAdmin()
  {
    $conn = $this->db->connect();
    $query = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'ADM' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'ADM001';
  }

  public function store($data)
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

    $query = "INSERT INTO users (id, username, email, password, role) VALUES (:id, :username, :email, :password, :role)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':username', $data['username']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':password', $data['password']);
      $stmt->bindParam(':role', $data['role']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../../admin/users.php',
        'message' => 'User created successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'User created failed: ' . $e->getMessage()
      ];
    }
  }

  public function storeAdmin($data)
  {
    $conn = $this->db->connect();
    $checkEmail = "SELECT email FROM users WHERE email = :email";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return ['status' => 'error', 'message' => 'Email already exists'];
    }

    $id = $this->generateIdAdmin();

    $query = "INSERT INTO users (id, username, email, password, role) VALUES (:id, :username, :email, :password, :role)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':username', $data['username']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':password', $data['password']);
      $stmt->bindParam(':role', $data['role']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../../admin/users.php',
        'message' => 'User created successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'User created failed: ' . $e->getMessage()
      ];
    }
  }

  public function update($id, $data)
  {
    $conn = $this->db->connect();
    $query = "UPDATE users SET username = :username, email = :email, role = :role, is_active = :is_active, updated_at = current_timestamp() WHERE id = :id";
    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':username', $data['username']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':role', $data['role']);
      $stmt->bindParam(':is_active', $data['is_active']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../users.php',
        'message' => 'User updated successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'User updated failed: ' . $e->getMessage()
      ];
    }
  }
  public function destroy($id)
  {
    $conn = $this->db->connect();
    $query = "DELETE FROM users WHERE id = :id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return [
        'status' => 'success',
        'redirect' => '../../admin/users.php',
        'message' => 'User deleted successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'User deleted failed: ' . $e->getMessage()
      ];
    }
  }
}
