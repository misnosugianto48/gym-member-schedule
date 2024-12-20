<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class MentorController
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }
  public function getMentors()
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM mentors";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $mentors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $mentors;
  }

  public function getMentorById($id)
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM mentors WHERE id = :id";
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
    $query = "SELECT id FROM mentors ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'MN' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'MN001';
  }

  public function createMentor($data)
  {
    $conn = $this->db->connect();
    $id = $this->generateId();

    $query = "INSERT INTO mentors (id, fullname, specialization, phone, email, status) VALUES (:id, :fullname, :specialization, :phone, :email, :status)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':fullname', $data['fullname']);
      $stmt->bindParam(':specialization', $data['specialization']);
      $stmt->bindParam(':phone', $data['phone']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':status', $data['status']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../../admin/mentors.php',
        'message' => 'Mentor created successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Mentor created failed: ' . $e->getMessage()
      ];
    }
  }

  public function updateMentor($id, $data)
  {
    $conn = $this->db->connect();
    $query = "UPDATE mentors SET fullname = :fullname, specialization = :specialization, phone = :phone, email = :email, status = :status WHERE id = :id";
    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':fullname', $data['fullname']);
      $stmt->bindParam(':specialization', $data['specialization']);
      $stmt->bindParam(':phone', $data['phone']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':status', $data['status']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../mentors.php',
        'message' => 'Mentor updated successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Mentor updated failed: ' . $e->getMessage()
      ];
    }
  }
  public function deleteMentor($id)
  {
    $conn = $this->db->connect();
    $query = "DELETE FROM mentors WHERE id = :id";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return [
        'status' => 'success',
        'redirect' => '../../admin/mentors.php',
        'message' => 'Mentor deleted successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Mentor deleted failed: ' . $e->getMessage()
      ];
    }
  }
}
