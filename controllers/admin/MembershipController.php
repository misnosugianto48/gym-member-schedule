<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../model/Database.php';

class MembershipController
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }

  public function getMemberships()
  {
    $conn = $this->db->connect();
    $query = "SELECT * FROM memberships";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $memberships;
  }
}
