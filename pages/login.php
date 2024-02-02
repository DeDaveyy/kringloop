<link rel="stylesheet" href="../src/style/main.css">
<?php
include ("../classes/dbh.class.php");
// User class voor de login
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Login valideren
    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM gebruiker WHERE gebruikersnaam = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['wachtwoord'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }

        return false;
    }

    // Check of de user ingelogd is
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Log de user
    public function logout()
    {
        session_destroy();
    }
}

// Start sessie
session_start();

$user = new User($pdo);

// Login form submit handelen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($user->login($username, $password)) {
            header('Location: /kringloop/index.php');
            exit();
        } else {
            $error = "Onjuiste gebruikersnaam of wachtwoord";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Login</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mainbuttons">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
