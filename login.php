<?php
require_once 'controllers/LoginController.php';

$loginController = new LoginController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = $loginController->login($email, $password);

  if ($result['status'] == 'success') {
    $_SESSION['alert'] = [
      'type' => 'success',
      'message' => 'Login successful!'
    ];
    header('Location: ' . $result['redirect']);
    exit();
  } else {
    $error = $result['message'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login Auth</title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="assets/img/kaiadmin/favicon.ico"
    type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">
  <div class="page-inner">
    <div class="row">
      <div class=" col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Login Page</div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <form role="form" class="form-action" method="post">
                  <div class="form-group">
                    <label for="email2">Email Address</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      placeholder="Enter Email"
                      name="email" />
                    <small id="email1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      placeholder="Password"
                      name="password" />

                  </div>
                  <a href="register.php">dont have account?</a>

                  <div class="card-action">
                    <button class="btn btn-success" type="submit" id="alert_demo_4">Login</button>
                    <a href="index.html" class="btn btn-danger">Cancel</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    <?php if (isset($error)): ?>
      swal({
        title: "Error!",
        text: "<?php echo $error; ?>",
        icon: "error",
        buttons: {
          confirm: {
            className: "btn btn-danger"
          }
        }
      });
    <?php endif; ?>
  </script>
</body>

</html>

<!-- After session check, before HTML -->
<?php if (isset($_SESSION['alert'])): ?>
  <script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    swal({
      title: "Success!",
      text: "<?php echo $_SESSION['alert']['message']; ?>",
      icon: "success",
      buttons: {
        confirm: {
          className: "btn btn-success"
        }
      }
    });
  </script>
<?php
  unset($_SESSION['alert']);
endif;
?>