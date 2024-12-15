<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../model/Database.php';

class LoginController
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function login($email, $password)
  {
    $conn = $this->db->connect();

    $query = "SELECT id, username, email, password, role FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['logged_in'] = true;

      // var_dump($_SESSION);
      // exit();

      if ($user['role'] == 0) {
        return ['status' => 'success', 'redirect' => 'views/admin/dashboard.php'];
      } else {
        return ['status' => 'success', 'redirect' => 'views/user/dashboard.php'];
      }
    }

    return ['status' => 'error', 'message' => 'Invalid credentials'];
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    return ['status' => 'success', 'redirect' => 'login.php'];
  }

  public function isLoggedIn()
  {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
  }

  public function isAdmin()
  {
    return isset($_SESSION['role']) && $_SESSION['role'] == 0;
  }

  public function isUser()
  {
    return isset($_SESSION['role']) && $_SESSION['role'] == 1;
  }
}
