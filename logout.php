<?php
require_once 'controllers/LoginController.php';

$loginController = new LoginController();
$result = $loginController->logout();

header('Location: ' . $result['redirect']);
exit();
