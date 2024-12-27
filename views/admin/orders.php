<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SESSION['role']);
require_once '../../controllers/LoginController.php';
require_once '../../controllers/admin/OrderController.php';


$loginController = new LoginController();
$orderController = new OrderController();
$orders = $orderController->getOrders();


// Check if user is logged in and is admin
if (!$loginController->isLoggedIn() || !$loginController->isAdmin()) {
  header('Location: ../../login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Orders</title>
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
            <li class="nav-item">
              <a href="./members.php">
                <i class="fas fa-user-plus"></i>
                <p>Members</p>
              </a>
            </li>
            <li class="nav-item active">
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
            <h3 class="fw-bold mb-3">Orders</h3>
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
                <a href="#">Data Orders</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Order Management</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="order-table" class="table table-hover">
                      <thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Member</th>
                          <th>Membership</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Payment Proof</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orders as $order): ?>
                          <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['member_name'] ?></td>
                            <td><?= $order['membership_name'] ?></td>
                            <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                            <td>
                              <span class="badge bg-<?=
                                                    $order['status'] == 'PAID' ? 'success' : ($order['status'] == 'PENDING' ? 'warning' : 'danger')
                                                    ?>">
                                <?= $order['status'] ?>
                              </span>
                            </td>

                            <td>
                              <?php if ($order['payment_proof']): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($order['payment_proof']) ?>"
                                  class="img-thumbnail"
                                  style="width: 100px; height: 100px; cursor: pointer"
                                  onclick="showFullImage(this.src)"
                                  alt="Payment Proof">
                              <?php else: ?>
                                <span class="badge bg-secondary">No proof uploaded</span>
                              <?php endif; ?>
                              </td< /td>
                            <td><?= date('d F Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                              <?php if ($order['status'] == 'PENDING'): ?>
                                <button class="btn btn-success btn-sm" onclick="confirmPayment('<?= $order['id'] ?>')">
                                  Confirm
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="rejectPayment('<?= $order['id'] ?>')">
                                  Reject
                                </button>
                              <?php endif; ?>
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
  <script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <script>
    function showFullImage(src) {
      swal({
        content: {
          element: "img",
          attributes: {
            src: src,
            style: "max-width: 100%"
          }
        },
        buttons: {
          confirm: {
            className: 'btn btn-success'
          }
        }
      });
    }

    function confirmPayment(orderId) {
      swal({
        title: 'Confirm Payment',
        text: "Are you sure to confirm this payment?",
        type: 'warning',
        buttons: {
          cancel: {
            visible: true,
            text: 'Cancel',
            className: 'btn btn-danger'
          },
          confirm: {
            text: 'Yes, Confirm',
            className: 'btn btn-success'
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = `orders/confirm.php?id=${orderId}`;
        }
      });
    }

    function rejectPayment(orderId) {
      swal({
        title: 'Reject Payment',
        text: "Are you sure to reject this payment?",
        type: 'warning',
        buttons: {
          cancel: {
            visible: true,
            text: 'Cancel',
            className: 'btn btn-danger'
          },
          confirm: {
            text: 'Yes, Reject',
            className: 'btn btn-success'
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = `orders/reject.php?id=${orderId}`;
        }
      });
    }

    $(document).ready(function() {
      $("#basic-datatables").DataTable({});
    });

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

    $(document).on('click', '.delete-btn', function(e) {
      e.preventDefault();
      const orderId = $(this).data('id');


      swal({
        title: 'Are you sure?',
        text: "This order will be permanently deleted!",
        type: 'warning',
        buttons: {
          cancel: {
            visible: true,
            className: 'btn btn-danger'
          },
          confirm: {
            text: 'Yes, delete it!',
            className: 'btn btn-success'
          }
        }
      }).then((willDelete) => {
        if (willDelete) {
          window.location.href = `./orderd/delete-orderd.php?id=${orderId}`;
        }
      });
    });
  </script>
</body>

</html>

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