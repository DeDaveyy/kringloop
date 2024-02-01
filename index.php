<?php 
include "includes/header.php"; 

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo 'Welcome, ' . $username . '!';
} else {
    echo 'Session not set.';
}


