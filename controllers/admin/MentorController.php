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
  public function createMentor($data)
  {
    $conn = $this->db->connect();
    $query = "INSERT INTO mentors (name, email, phone, address, bio, image) VALUES (:name, :email, :phone, :address, :bio, :image)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':bio', $data['bio']);
    $stmt->bindParam(':image ', $data['image']);
    $stmt->execute();
    return $stmt->rowCount();
  }
  public function updateMentor($id, $data)
  {
    $conn = $this->db->connect();
    $query = "UPDATE mentors SET name = :name, email = :email, phone = :phone, address = :address, bio = :bio, image = :image WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(': id', $id);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':bio', $data['bio']);
    $stmt->bindParam(':image', $data['image']);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function deleteMentor($id)
  {
    $conn = $this->db->connect();
    $query = "DELETE FROM mentors WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->rowCount();
  }
}
