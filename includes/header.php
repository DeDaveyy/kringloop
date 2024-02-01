<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Page Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the navbar */
        .navbar-custom {
            background-color: #007bff; /* Blue background color */
        }
        .navbar-custom a {
            color: #fff !important; /* White text color */
        }
        .navbar-custom .dropdown-item {
            color: #000 !important; /* Black text color for dropdown item */
        }
        .custom-button {
            background-color: #007bff; /* Blue button color */
            color: #fff !important; /* White text color */
            border: 1px solid #fff; /* White border */
            border-radius: 5px; /* Rounded corners */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">Kringloop centrum</a>
    <!-- Aanmelden button -->
    <a class="btn custom-button" href="aanmelden.php">Aanmelden</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ritten
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="ritten_planning.php">Ritten Planning</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="voorraad.php">Voorraad</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="#">Admin Item 1</a>
                    <a class="dropdown-item" href="#" data-toggle="dropdown-submenu" aria-haspopup="true" aria-expanded="false">Admin Item 2</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Sub-Item 1</a>
                        <a class="dropdown-item" href="#">Sub-Item 2</a>
                        <a class="dropdown-item" href="#">Sub-Item 3</a>
                    </div>
                    <a class="dropdown-item" href="#">Admin Item 3</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
