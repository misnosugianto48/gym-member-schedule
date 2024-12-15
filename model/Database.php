
<?php
class Database
{
  private $host = "127.0.0.1";
  private $username = "root";
  private $password = "root";
  private $database = "gym_schedule_db";
  private $conn;

  public function connect()
  {
    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->host . ";dbname=" . $this->database,
        $this->username,
        $this->password
      );
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->conn;
    } catch (PDOException $e) {
      echo "Connection Error: " . $e->getMessage();
      return null;
    }
  }

  public function disconnect()
  {
    $this->conn = null;
  }
}
?>
