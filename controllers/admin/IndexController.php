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

  public function getDashboardStats()
  {
    $conn = $this->db->connect();

    // Total Members
    $memberQuery = "SELECT COUNT(*) as total FROM members";
    $stmt = $conn->query($memberQuery);
    $members = $stmt->fetch(PDO::FETCH_ASSOC);

    // Total Active Memberships
    $membershipQuery = "SELECT COUNT(*) as total FROM orders WHERE status = 'PAID'";
    $stmt = $conn->query($membershipQuery);
    $memberships = $stmt->fetch(PDO::FETCH_ASSOC);

    // Total Mentors
    $mentorQuery = "SELECT COUNT(*) as total FROM mentors";
    $stmt = $conn->query($mentorQuery);
    $mentors = $stmt->fetch(PDO::FETCH_ASSOC);

    // Total Bookings
    $bookingQuery = "SELECT COUNT(*) as total FROM bookings";
    $stmt = $conn->query($bookingQuery);
    $bookings = $stmt->fetch(PDO::FETCH_ASSOC);

    // Recent Members
    $recentMembersQuery = "SELECT m.*, u.username, u.email 
                            FROM members m 
                            JOIN users u ON m.user_id = u.id 
                            ORDER BY m.created_at DESC LIMIT 5";
    $stmt = $conn->query($recentMembersQuery);
    $recentMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recent Transactions
    $transactionQuery = "SELECT o.*, m.name as membership_name, mb.fullname as member_name 
                         FROM orders o
                         JOIN memberships m ON o.membership_id = m.id
                         JOIN members mb ON o.member_id = mb.id
                         ORDER BY o.created_at DESC LIMIT 7";
    $stmt = $conn->query($transactionQuery);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'total_members' => $members['total'],
      'total_memberships' => $memberships['total'],
      'total_mentors' => $mentors['total'],
      'total_bookings' => $bookings['total'],
      'recent_members' => $recentMembers,
      'transactions' => $transactions
    ];
  }
}
