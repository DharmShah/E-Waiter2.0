<?php
session_start();

// Store selected table number in session if provided
if (isset($_GET['table'])) {
    $_SESSION['selectedTable'] = $_GET['table'];
}

header("Location: menu.php"); // Redirect to the menu page
exit;
