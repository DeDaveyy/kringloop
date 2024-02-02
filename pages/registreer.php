<link rel="stylesheet" href="../src/style/main.css">
<?php
// Database configureren
$dbHost = 'localhost';
$dbName = 'duurzaam';
$dbUser = 'root';
$dbPass = '';

// Database connectie maken met PDO
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// User class voor registreren
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // nieuwe user registreren
    public function register($username, $password)
    {
        // Checken of de gebruikersnaam al bestaat
        $stmt = $this->pdo->prepare("SELECT * FROM gebruiker WHERE gebruikersnaam = ?");
        $stmt->execute([$username]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            return false;
        }

        // Nieuwe gebruiker het database in stoppen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO gebruiker (gebruikersnaam, wachtwoord) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);

        return true;
    }
}

// Sessie starten
session_start();

$user = new User($pdo);

// Registratie form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gebruikersnaam'], $_POST['wachtwoord'])) {
        $username = $_POST['gebruikersnaam'];
        $password = $_POST['wachtwoord'];

        if ($user->register($username, $password)) {
            header('Location: login.php');
            exit();
        } else {
            $error = "registreren is gefaald";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Registreren</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="gebruikersnaam">gebruikersnaam</label>
                        <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>
                    </div>
                    <div class="form-group">
                        <label for="wachtwoord">wachtwoord</label>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
                    </div>
                    <button type="submit" class="btn btn-primary loginbutton">Registreer</button>
                </form>
                <button class="btn btn-primary mainbuttons"><a href="../pages/login.php" class="text-white">Login</a></button>
            </div>
        </div>
    </div>
</body>
</html>
