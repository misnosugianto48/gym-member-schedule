<?php
require_once 'Database.php';

$database = new Database();
$conn = $database->connect();

if ($conn) {
  echo "Database connection successful!";
} else {
  echo "Database connection failed!";
}

$database->disconnect();
