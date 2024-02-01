<?php

require "../classes/auth.class.php";

$db = new Dbh();
$auth = new Auth($db);

if ($auth->login("example_username", "example_password")) {
    echo "Login successful!";
} else {
    echo "Login failed!";
}

// Example check if user is authenticated
if ($auth->isAuthenticated()) {
    echo "User is authenticated!";
} else {
    echo "User is not authenticated!";
}