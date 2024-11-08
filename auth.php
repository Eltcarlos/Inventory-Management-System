<?php
session_start();

if (!isset($_SESSION['isAuthenticated']) || $_SESSION['isAuthenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
