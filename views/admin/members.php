<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SESSION['role']);
require_once '../../controllers/LoginController.php';
require_once '../../controllers/admin/MembersController.php';

$loginController = new LoginController();
$membersController = new MembersController();
$members = $membersController->getMembers();


// Check if user is logged in and is admin
if (!$loginController->isLoggedIn() || !$loginController->isAdmin()) {
  header('Location: ../../login.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Members</title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="../../assets/img/kaiadmin/favicon.ico"
    type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
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
        urls: ["../../assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../../assets/css/kaiadmin.min.css" />

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="white">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="./dashboard.php" class="logo">
            <img
              src="../../assets/img/kaiadmin/logo_light.svg"
              alt="navbar brand"
              class="navbar-brand"
              height="20" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item ">
              <a href="./dashboard.php">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Action</h4>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#base">
                <i class="fas fa-layer-group"></i>
                <p>Base</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="base">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="./mentors.php">
                      <span class="sub-item">Mentors</span>
                    </a>
                  </li>
                  <li>
                    <a href="./memberships.php">
                      <span class="sub-item">Memberships</span>
                    </a>
                  <li>
                    <a href="./users.php">
                      <span class="sub-item">Users</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item active ">
              <a href="./members.php">
                <i class="fas fa-user-plus"></i>
                <p>Members</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./orders.php">
                <i class="fas fa-file"></i>
                <p>Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./schedules.php">
                <i class="fas fa-calendar-plus"></i>
                <p>Schedules</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./bookings.php">
                <i class="fas fa-book"></i>
                <p>Booking</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav
          class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav
              class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li class="nav-item topbar-icon dropdown hidden-caret">
                <a
                  class="nav-link"
                  data-bs-toggle="dropdown"
                  href="#"
                  aria-expanded="false">
                  <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions animated fadeIn">
                  <div class="quick-actions-header">
                    <span class="title mb-1">Quick Actions</span>
                    <span class="subtitle op-7">Shortcuts</span>
                  </div>
                  <div class="quick-actions-scroll scrollbar-outer">
                    <div class="quick-actions-items">
                      <div class="row m-0">
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div class="avatar-item bg-danger rounded-circle">
                              <i class="far fa-calendar-alt"></i>
                            </div>
                            <span class="text">Calendar</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div
                              class="avatar-item bg-warning rounded-circle">
                              <i class="fas fa-map"></i>
                            </div>
                            <span class="text">Maps</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div class="avatar-item bg-info rounded-circle">
                              <i class="fas fa-file-excel"></i>
                            </div>
                            <span class="text">Reports</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div
                              class="avatar-item bg-success rounded-circle">
                              <i class="fas fa-envelope"></i>
                            </div>
                            <span class="text">Emails</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div
                              class="avatar-item bg-primary rounded-circle">
                              <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <span class="text">Invoice</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <div
                              class="avatar-item bg-secondary rounded-circle">
                              <i class="fas fa-credit-card"></i>
                            </div>
                            <span class="text">Payments</span>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item topbar-user dropdown hidden-caret">
                <a
                  class="dropdown-toggle profile-pic"
                  data-bs-toggle="dropdown"
                  href="#"
                  aria-expanded="false">
                  <div class="avatar-sm">
                    <img
                      src="../../assets/img/profile.jpg"
                      alt="..."
                      class="avatar-img rounded-circle" />
                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold"><?= $_SESSION['username']; ?></span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar-lg">
                          <img
                            src="../../assets/img/profile.jpg"
                            alt="image profile"
                            class="avatar-img rounded" />
                        </div>
                        <div class="u-text">
                          <h4><?= $_SESSION['username']; ?></h4>
                          <p class="text-muted"><?= $_SESSION['email']; ?></p>
                          <a
                            href="./profile.php"
                            class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                          <a
                            href="#"
                            class="btn btn-xs btn-warning btn-sm" id="logout-btn">Logout</a>
                        </div>
                      </div>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Members</h3>

            </div>
          </div>
          <div class="row">
            <!-- Statistics Cards -->
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Members Management</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="members-table" class="table table-hover">
                    <thead>
                      <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Membership</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($members as $member): ?>
                        <tr>
                          <td><?= $member['id'] ?></td>
                          <td><?= $member['fullname'] ?></td>
                          <td><?= $member['email'] ?></td>
                          <td><?= $member['phone'] ?></td>
                          <td><?= $member['gender'] ?></td>
                          <td>
                            <span class="badge bg-<?= $member['membership_status'] == 'PAID' ? 'success' : 'warning' ?>">
                              <?= $member['membership_status'] ? 'Active' : 'Inactive' ?>
                            </span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


          </div>

        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="http://www.themekita.com">
                  ThemeKita
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Help </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Licenses </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            2024, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="http://www.themekita.com">ThemeKita</a>
          </div>
          <div>
            Distributed by
            <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="../../assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Chart JS -->
  <script src="../../assets/js/plugin/chart.js/chart.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="../../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

  <!-- Chart Circle -->
  <script src="../../assets/js/plugin/chart-circle/circles.min.js"></script>

  <!-- Datatables -->
  <script src="../../assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="../../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- jQuery Vector Maps -->
  <script src="../../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="../../assets/js/plugin/jsvectormap/world.js"></script>

  <!-- Sweet Alert -->
  <script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="../../assets/js/kaiadmin.min.js"></script>

  <!-- Kaiadmin DEMO methods, don't include it in your project! -->
  <script src="../../assets/js/setting-demo.js"></script>
  <script src="../../assets/js/demo.js"></script>
  <script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#177dff",
      fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#f3545d",
      fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#ffa534",
      fillColor: "rgba(255, 165, 52, .14)",
    });
  </script>
  <script>
    function viewMember(memberId) {
      $.get(`members/get_details.php?id=${memberId}`, function(data) {
        $('#memberDetails').html(data);
        $('#memberModal').modal('show');
      });
    }

    $(document).ready(function() {
      $('#members-table').DataTable({
        order: [
          [1, 'asc']
        ]
      });
    });
  </script>
  <script>
    document.getElementById('logout-btn').addEventListener('click', function() {
      swal({
        title: 'Are you sure?',
        text: "You will be logged out of the system!",
        type: 'warning',
        buttons: {
          cancel: {
            visible: true,
            className: 'btn btn-danger'
          },
          confirm: {
            text: 'Yes, logout!',
            className: 'btn btn-success'
          }
        }
      }).then((willLogout) => {
        if (willLogout) {
          window.location.href = '../../logout.php';
        }
      });
    });
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