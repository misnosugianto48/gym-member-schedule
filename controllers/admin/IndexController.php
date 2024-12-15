<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class IndexController
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }

  public function getUsers()
  {
    $conn = $this->db->connect();

    // Get total users count
    $countQuery = "SELECT COUNT(*) as total FROM users";
    $countStmt = $conn->query($countQuery);
    $totalUsers = $countStmt->fetch(PDO::FETCH_ASSOC);

    // Get all users data
    $usersQuery = "SELECT * FROM users where role = 1 ORDER BY id DESC";
    $usersStmt = $conn->query($usersQuery);
    $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'total' => $totalUsers['total'],
      'users' => $users
    ];
  }

  public function getMentors()
  {
    $conn = $this->db->connect();
    $query = "SELECT COUNT(*) as total FROM mentors";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $mentors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $mentors[0]['total'];
  }
}
