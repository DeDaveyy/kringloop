<?php


require_once "../classes/user.class.php"; 
session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $user = new User("", "", ""); 

   
    if ($user->login($username, $password)) {
        
        $_SESSION['user_id'] = $username; 

        
        header("Location: ../index.php");
        exit();
    } else {
        
        $error_message = "Invalid username or password";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>

    <?php
   
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <br>

        <input type="submit" value="Login">
    </form>

</body>
</html>
