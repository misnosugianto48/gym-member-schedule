<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SESSION['role']);
require_once '../../controllers/LoginController.php';
require_once '../../controllers/user/ScheduleController.php';

$loginController = new LoginController();
$scheduleController = new ScheduleController();

if (!$loginController->isLoggedIn() || !$loginController->isUser()) {
  header('Location: ../../login.php');
  exit();
}

$availableSchedules = $scheduleController->getAvailableSchedules();
$mySchedules = $scheduleController->getMySchedules($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Schedules</title>
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
            <li class="nav-item">
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
              <a href="./memberships.php">
                <i class="fas fa-user-plus"></i>
                <p>Memberships</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./payments.php">
                <i class="fas fa-file"></i>
                <p>Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./schedules.php">
                <i class="fas fa-calendar-plus"></i>
                <p>Schedules</p>
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
            <a href="#" class="logo">
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
          <div class="page-header">
            <h3 class="fw-bold mb-3">Profile</h3>
            <ul class="breadcrumbs mb-3">
              <li class="nav-home">
                <a href="./dashboard.php">
                  <i class="icon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="./schedules.php">Schedules</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Available Training Schedules</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="schedule-table" class="table table-hover">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Mentor</th>
                          <th>Quota</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($availableSchedules as $schedule): ?>
                          <tr>
                            <td><?= date('d F Y', strtotime($schedule['date'])) ?></td>
                            <td><?= date('H:i', strtotime($schedule['start_at'])) ?> - <?= date('H:i', strtotime($schedule['end_at'])) ?></td>
                            <td><?= $schedule['mentor_name'] ?></td>
                            <td><?= $schedule['remaining'] ?>/<?= $schedule['quota'] ?></td>
                            <td>
                              <span class="badge bg-<?= $schedule['status'] == 'SCHEDULED' ? 'success' : 'secondary' ?>">
                                <?= $schedule['status'] ?>
                              </span>
                            </td>
                            <td>
                              <?php if ($schedule['remaining'] < $schedule['quota']): ?>
                                <button class="btn btn-primary btn-sm" onclick="bookSchedule('<?= $schedule['id'] ?>')">
                                  Book Now
                                </button>
                              <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Full</button>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

              <div class="card mt-4">
                <div class="card-header">
                  <h4 class="card-title">My Training Schedules</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Mentor</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($mySchedules as $schedule): ?>
                          <tr>
                            <td><?= date('d F Y', strtotime($schedule['date'])) ?></td>
                            <td><?= date('H:i', strtotime($schedule['start_at'])) ?> - <?= date('H:i', strtotime($schedule['end_at'])) ?></td>
                            <td><?= $schedule['mentor_name'] ?></td>
                            <td>
                              <span class="badge bg-<?= $schedule['status'] == 'CONFIRMED' ? 'success' : 'warning' ?>">
                                <?= $schedule['status'] ?>
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
  <!-- Datatables -->
  <script src="../../assets/js/plugin/datatables/datatables.min.js"></script>
  <!-- Kaiadmin JS -->
  <script src="../../assets/js/kaiadmin.min.js"></script>
  <!-- Sweet Alert -->
  <script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <script>
    function bookSchedule(scheduleId) {
      swal({
        title: 'Book Schedule',
        text: "Are you sure to book this schedule?",
        type: 'warning',
        buttons: {
          cancel: {
            visible: true,
            text: 'Cancel',
            className: 'btn btn-danger'
          },
          confirm: {
            text: 'Yes, Book',
            className: 'btn btn-success'
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = `book_schedule.php?id=${scheduleId}`;
        }
      });
    }

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

    $(document).ready(function() {
      $("#basic-datatables").DataTable({});
    });
  </script>
</body>

</html>