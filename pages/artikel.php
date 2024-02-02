<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Benodigde files
require ("../functions/artikel.function.php");
require ("../classes/dbh.class.php");
require ("../includes/leftheader.includes.php");
require ("../functions/categorie.function.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Kijkt of het formulier is verstuurd
    if (isset($_POST['createArtikel'])) {
        //krijgt data van het formulier
        $categorie_id = $_POST['create_categorie_id'];
        $naam = $_POST['create_naam'];
        $prijs_ex_btw = $_POST['create_prijs_ex_btw'];
        //Roept de functie create Artikel op met de ontvangen data.
        createArtikel($pdo, $categorie_id, $naam, $prijs_ex_btw);
        header("Location: artikel.php"); // Stuurt je terug nadat de functie is uitgevoerd
        exit();
        
        //Kijkt of de data voor update is ontvangen
    } elseif (isset($_POST['updateArtikel'])) {
        //Krijgt data van het formulier
        $id = $_POST['id'];
        $categorie_id = $_POST['update_categorie_id'];
        $naam = $_POST['update_naam'];
        $prijs_ex_btw = $_POST['update_prijs_ex_btw'];
        //Roept de functie  updateArtikel aan en geeft deze de ontvangen data
        updateArtikel($pdo, $id, $categorie_id, $naam, $prijs_ex_btw);
        header("Location: artikel.php"); // Stuurt je terug nadat de functie is uitgevoerd
        exit();
        //Kijkt of formulier is ontvangen
    } elseif (isset($_POST['confirmDelete'])) {
        //Krijgt data van het formulier
        $id = $_POST['id'];
        //Roept  de delete functie aan en geef hem de id mee
        deleteArtikel($pdo, $id);
        header("Location: artikel.php"); // Stuurt je terug nadat de functie is uitgevoerd
        exit();
    }
}

//Variablen  die worden gebruikt in de view 
$artikels = readArtikels($pdo);
$categories = readCategories($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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

<div class="container mt-4">
    <h1 class="mb-4">Artikels</h1>

    <form class="form-inline mb-3">
        <div class="form-group mx-sm-3 mb-2">
            <label for="searchInput" class="sr-only">Zoeken</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Zoek bij naam of categorie">
        </div>
        <button type="button" class="btn btn-primary mb-2" onclick="searchArtikels()" placeholder="Nog niet functioneel">Zoek</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Prijs (excl. BTW)</th>
                <th>Categorie ID</th>
                <th>Categorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //Maakt een loop om alle artikelen in de database te laten zien
            foreach ($artikels as $artikel) : 
            ?>
                <tr>
                    <!--Laat de data zien in de tabel  -->
                    <td><?php echo $artikel['artikel_id']; ?></td>
                    <td><?php echo $artikel['naam']; ?></td>
                    <td><?php echo $artikel['prijs_ex_btw']; ?></td>
                    <td><?php echo $artikel['categorie_id']; ?></td>
                    <td><?php echo $artikel['categorie']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $artikel['artikel_id']; ?>">
                            <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo $artikel['artikel_id']; ?>, '<?php echo $artikel['naam']; ?>', <?php echo $artikel['categorie_id']; ?>, '<?php echo $artikel['prijs_ex_btw']; ?>')">Aanpassen</button>
                            <button type="submit" name="confirmDelete" class="btn btn-danger btn-sm">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Button to open Create Artikel modal -->
    <button type="button" class="btn btn-success mt-3" onclick="openCreateModal()">
     Artikel aanmaken</button>

<!-- Create Artikel Modal -->
<div class="modal" id="createArtikelModal" tabindex="-1" role="dialog" aria-labelledby="createArtikelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createArtikelModalLabel">Aanmaken Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#createArtikelModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for creating an artikel -->
                <form method="post" action="artikel.php">
                    <div class="form-group">
                        <label for="createArtikelNaam">Naam:</label>
                        <input type="text" class="form-control" id="createArtikelNaam" name="create_naam" required>
                    </div>
                    <div class="form-group">
                        <label for="createArtikelCategorieId">Categorie:</label>
                        <select class="form-control" id="createArtikelCategorieId" name="create_categorie_id" required>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['categorie']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createArtikelPrijsExBtw">Prijs (excl. BTW):</label>
                        <input type="text" class="form-control" id="createArtikelPrijsExBtw" name="create_prijs_ex_btw" required>
                    </div>
                    <button type="submit" name="createArtikel" class="btn btn-success">Aanmaken Artikel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Artikel Modal -->
<div class="modal" id="editArtikelModal" tabindex="-1" role="dialog" aria-labelledby="editArtikelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArtikelModalLabel">Aanpassen Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#editArtikelModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing an artikel -->
                <form method="post" action="artikel.php">
                    <input type="hidden" id="editArtikelId" name="id">
                    <div class="form-group">
                        <label for="editArtikelNaam">Naam:</label>
                        <input type="text" class="form-control" id="editArtikelNaam" name="update_naam" required>
                    </div>
                    <div class="form-group">
                        <label for="editArtikelCategorieId">Categorie:</label>
                        <select class="form-control" id="editArtikelCategorieId" name="update_categorie_id" required>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['categorie']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editArtikelPrijsExBtw">Prijs (excl. BTW):</label>
                        <input type="text" class="form-control" id="editArtikelPrijsExBtw" name="update_prijs_ex_btw" required>
                    </div>
                    <button type="submit" name="updateArtikel" class="btn btn-primary">Aanpassen Artikel</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Modal overlay -->
    <div class="modal-overlay" onclick="closeAllModals()"></div>

</div>
<script 
src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
</script>
<script>
    //Voegt een eventlistener als je op ESC drukt dat de modal sluit.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllModals();
        }
    });
    

    //Open de edit modal
    function openEditModal(id, naam, categorie_id, prijs_ex_btw) {
        // Zet waarde edit artikel modal
        document.getElementById('editArtikelId').value = id;
        document.getElementById('editArtikelNaam').value = naam;
        document.getElementById('editArtikelCategorieId').value = categorie_id;
        document.getElementById('editArtikelPrijsExBtw').value = prijs_ex_btw;

        // Open de Edit Artikel Modal
        document.getElementById('editArtikelModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function openCreateModal() {
        // Open de Create Artikel Modal
        document.getElementById('createArtikelModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function closeModal(modalId) {
        // Close de modal
        document.querySelector(modalId).style.display = 'none';
        document.querySelector('.modal-overlay').style.display = 'none';
    }

    function closeAllModals() {
        closeModal('#createArtikelModal');
        closeModal('#editArtikelModal');
    }
</script>

