<?php
// admin/logout.php - Logout Admin
session_start();
session_destroy();
redirect('login.php');
?>
