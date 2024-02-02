<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../functions/klant.function.php');  
include ("../includes/leftheader.includes.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Kijkt of het formulier is ontvangen
    if (isset($_POST['createKlant'])) {
        //ontvangt de data en zet het in variabelen
        $name = $_POST["klantNaam"];
        $adres = $_POST['klantAdres'];
        $plaats = $_POST['klantPlaats'];
        $telefoon = $_POST['klantTelefoon'];
        $email = $_POST['klantEmail'];
        createKlant($pdo, $name, $adres, $plaats, $telefoon, $email);
        header("Location: persoonsgegevens.php"); // Stuurt je naar persoongegevens
        exit();
        //Kijkt of het formulier is gestuurd
    } elseif (isset($_POST['updateKlant'])) {
        //ontvangt de data en zet het in variabelen
        $id = $_POST['id'];
        $adres = $_POST['klantAdres'];
        $name = $_POST["klantNaam"];
        $plaats = $_POST['klantPlaats'];
        $telefoon = $_POST['klantTelefoon'];
        $email = $_POST['klantEmail'];
        updateKlant($pdo, $id, $name, $adres, $plaats, $telefoon, $email);
        header("Location: persoonsgegevens.php"); // Stuurt je naar persoongegevens
        exit();
        //Kijkt of het formulier is ontvangen
    } elseif (isset($_POST['confirmDelete'])) {
        //ontvangt de data en zet het in variabelen
        $id = $_POST['id'];
        deleteKlant($pdo, $id);
        header("Location: persoonsgegevens.php"); // Stuurt je naar persoongegevens
        exit();
    }
}


$klanten = readKlanten($pdo); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorieen beheren</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            margin-left: 25%;
            width: 70%;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: none;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Klanten</h1>

    <form class="form-inline mb-3">
        <div class="form-group mx-sm-3 mb-2">
            <label for="searchInput" class="sr-only">Zoeken</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Search by name or code">
        </div>
        <button type="button" class="btn btn-primary mb-2" onclick="searchCategories()">Zoek</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Adres</th>
                <th>Plaats</th>
                <th>Telefoon</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($klanten as $klant) : ?>
                <tr>
                    <td><?php echo $klant['id']; ?></td>
                    <td><?php echo $klant['naam']; ?></td>
                    <td><?php echo $klant['adres']; ?></td>
                    <td><?php echo $klant['plaats']; ?></td>
                    <td><?php echo $klant['telefoon']; ?></td>
                    <td><?php echo $klant['email']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $klant['id']; ?>">
                            <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo $klant['id']; ?>,<?php echo $klant['naam']; ?> '<?php echo $klant['adres']; ?>', '<?php echo $klant['plaats']; ?>', '<?php echo $klant['telefoon']; ?>', '<?php echo $klant['email']; ?>')">Aanpassen</button>
                            <button type="submit" name="confirmDelete" class="btn btn-danger btn-sm">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-success mt-3" onclick="openCreateModal()">Klant aanmaken</button>

    <div class="modal" id="createKlantModal" tabindex="-1" role="dialog" aria-labelledby="createKlantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createKlantModalLabel">Klant aanmaken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#createKlantModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="klantNaam">Naam:</label>
                        <input type="text" class="form-control" name="klantNaam" required>
                    </div>
                    <div class="form-group">
                        <label for="klantAdres">Adres:</label>
                        <input type="text" class="form-control" name="klantAdres" required>
                    </div>
                    <div class="form-group">
                        <label for="klantPlaats">Plaats:</label>
                        <input type="text" class="form-control" name="klantPlaats" required>
                    </div>
                    <div class="form-group">
                        <label for="klantTelefoon">Telefoon:</label>
                        <input type="text" class="form-control" name="klantTelefoon" required>
                    </div>
                    <div class="form-group">
                        <label for="klantEmail">Email:</label>
                        <input type="email" class="form-control" name="klantEmail" required>
                    </div>
                    <button type="submit" name="createKlant" class="btn btn-success">Aanmaken Klant</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editKlantModal" tabindex="-1" role="dialog" aria-labelledby="editKlantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKlantModalLabel">Aanpassen Klant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#editKlantModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" id="editKlantId" name="id">
                    <div class="form-group">
                        <label for="editklantNaam">Naam:</label>
                        <input type="text" class="form-control" id="editklantNaams" name="klantAdres" required>
                    </div>
                    <div class="form-group">
                        <label for="editKlantAdres">Adres:</label>
                        <input type="text" class="form-control" id="editKlantAdres" name="klantAdres" required>
                    </div>
                    <div class="form-group">
                        <label for="editKlantPlaats">Plaats:</label>
                        <input type="text" class="form-control" id="editKlantPlaats" name="klantPlaats" required>
                    </div>
                    <div class="form-group">
                        <label for="editKlantTelefoon">Telefoon:</label>
                        <input type="text" class="form-control" id="editKlantTelefoon" name="klantTelefoon" required>
                    </div>
                    <div class="form-group">
                        <label for="editKlantEmail">Email:</label>
                        <input type="email" class="form-control" id="editKlantEmail" name="klantEmail" required>
                    </div>
                    <button type="submit" name="updateKlant" class="btn btn-primary">Aanpassen Klant</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="modal-overlay" onclick="closeAllModals()"></div>


</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
     document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAllModals();
        }
    });

    function searchCategories() {
    var searchInput = document.getElementById('searchInput').value.toLowerCase();
    var tableRows = document.querySelectorAll('.table tbody tr');

    tableRows.forEach(function(row) {
        var categoryName = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        var categoryCode = row.querySelector('td:nth-child(3)').innerText.toLowerCase();

        if (categoryName.includes(searchInput) || categoryCode.includes(searchInput)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}


    function openEditModal(id, categoryName, categoryCode) {

    document.getElementById('editKlantId').value = id;
    document.getElementById('editKlantName').value = categoryName;
    document.getElementById('editKlantCode').value = categoryCode;

    document.getElementById('editKlantModal').style.display = 'block';
    document.querySelector('.modal-overlay').style.display = 'block';
}


    function openCreateModal() {

        document.getElementById('createKlantModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function closeModal(modalId) {

        document.querySelector(modalId).style.display = 'none';
        document.querySelector('.modal-overlay').style.display = 'none';
    }

    function closeAllModals() {
        closeModal('#createKlantModal');
        closeModal('#editKlantModal');
    }
</script>

</body>
</html>
