<?php
require_once 'controllers/RegisterController.php';

$registerController = new RegisterController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  $result = $registerController->register($username, $email, $password, $role, $is_active);

  if ($result['status'] == 'success') {
    $_SESSION['alert'] = [
      'type' => 'success',
      'message' => 'Register successful!'
    ];
    header('Location: ./login.php');
    exit();
  } else {
    $error = $result['message'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Admin</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Register Page</div>
          </div>
          <div class="card-body">
            <form method="POST" action="" role="form">
              <div class="row">
                <!-- Left Column -->
                <div class="col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                </div>

                <!-- Right Column -->
                <!-- <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                      <option value="0">Admin</option>
                      <option value="1">User</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                      <label class="custom-control-label" for="is_active">Active Status</label>
                    </div>
                  </div>
                </div> -->
              </div>

              <div class="card-action">
                <button type="submit" class="btn btn-success">Register</button>
                <a href="login.php" class="btn btn-danger">Cancel</a>
              </div>
            </form>
            <?php if (isset($error)): ?>
              <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>