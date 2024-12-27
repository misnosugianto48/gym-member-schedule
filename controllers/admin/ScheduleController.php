<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class ScheduleController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getSchedule()
  {
    $conn = $this->db->connect();
    $query = "SELECT schedules.* , mentors.fullname, mentors.specialization FROM schedules INNER JOIN mentors ON mentors.id = schedules.mentor_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $schedules;
  }

  public function getScheduleById($id)
  {
    $conn = $this->db->connect();
    $query = "SELECT schedules.*, mentors.* FROM schedules INNER JOIN mentors ON mentors.id = schedules.mentor_id WHERE schedules.id = :id";
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
    $query = "SELECT id FROM schedules ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($query);
    $lastId = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastId) {
      $numericPart = intval(substr($lastId['id'], 3)) + 1;
      return 'SC' . str_pad($numericPart, 3, '0', STR_PAD_LEFT);
    }

    return 'SC001';
  }

  public function store($data)
  {
    $conn = $this->db->connect();
    $id = $this->generateId();

    $query = "INSERT INTO schedules (id, mentor_id, start_at, end_at, date, quota) VALUES (:id, :mentor_id, :start_at, :end_at, :date, :quota)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':mentor_id', $data['mentor_id']);
      $stmt->bindParam(':start_at', $data['start_at']);
      $stmt->bindParam(':end_at', $data['end_at']);
      $stmt->bindParam(':date', $data['date']);
      $stmt->bindParam(':quota', $data['quota']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../../admin/schedules.php',
        'message' => 'Schedules created successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Schedules created failed: ' . $e->getMessage()
      ];
    }
  }

  public function update($id, $data)
  {
    $conn = $this->db->connect();
    $query = "UPDATE schedules SET mentor_id = :mentor_id, start_at = :start_at, end_at = :end_at, date = :date, quota = :quota, status = :status WHERE id = :id";
    try {
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':mentor_id', $data['mentor_id']);
      $stmt->bindParam(':start_at', $data['start_at']);
      $stmt->bindParam(':end_at', $data['end_at']);
      $stmt->bindParam(':date', $data['date']);
      $stmt->bindParam(':quota', $data['quota']);
      $stmt->bindParam(':status', $data['status']);
      $stmt->execute();

      return [
        'status' => 'success',
        'redirect' => '../schedules.php',
        'message' => 'Schedule updated successful'
      ];
    } catch (PDOException $e) {
      return [
        'status' => 'error',
        'message' => 'Schedule updated failed: ' . $e->getMessage()
      ];
    }
  }
}
