<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../functions/categorie.function.php');
include ("../includes/leftheader.includes.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['createCategory'])) {
        $name = $_POST['categoryName'];
        $code = $_POST['categoryCode'];
        createCategorie($pdo, $name, $code);
    } elseif (isset($_POST['updateCategory'])) {
        $id = $_POST['id'];
        $name = $_POST['categoryName'];
        $code = $_POST['categoryCode'];
        updateCategorie($pdo, $id, $name, $code);
    } elseif (isset($_POST['confirmDelete'])) {
        $id = $_POST['id'];
        deleteCategorie($pdo, $id);
    }
}

$categories = readCategories($pdo);
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
    <h1 class="mb-4">Categories</h1>

    <!-- Zoekbalk -->
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
                <th>Code</th>
                <th>Omschrijving</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['code']; ?></td>
                    <td><?php echo $category['categorie']; ?></td>
                    <td>
                        <form method="post" action="categorie.php">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo $category['id']; ?>, '<?php echo $category['categorie']; ?>', '<?php echo $category['code']; ?>')">Aanpassen</button>
                            <button type="submit" name="confirmDelete" class="btn btn-danger btn-sm">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-success mt-3" onclick="openCreateModal()">Categorie aanmaken</button>

    <div class="modal" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Categorie aanmaken</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#createCategoryModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="categorie.php">
                        <div class="form-group">
                            <label for="categoryName">Categorie Naam:</label>
                            <input type="text" class="form-control" name="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryCode">Category Code (max 3 characters):</label>
                            <input type="text" class="form-control" name="categoryCode" maxlength="3" required>
                        </div>
                        <button type="submit" name="createCategory" class="btn btn-success">Aanmaken Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Aanpassen Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#editCategoryModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="categorie.php">
                        <input type="hidden" id="editCategoryId" name="id">
                        <div class="form-group">
                            <label for="editCategoryName">Category Naam:</label>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="editCategoryCode">Category Code (max 3 characters):</label>
                            <input type="text" class="form-control" id="editCategoryCode" name="categoryCode" maxlength="3" required>
                        </div>
                        <button type="submit" name="updateCategory" class="btn btn-primary">Aanpassen Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" onclick="closeAllModals()"></div>

</div>

<script 
src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
</script>

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

    document.getElementById('editCategoryId').value = id;
    document.getElementById('editCategoryName').value = categoryName;
    document.getElementById('editCategoryCode').value = categoryCode;

    document.getElementById('editCategoryModal').style.display = 'block';
    document.querySelector('.modal-overlay').style.display = 'block';
}


    function openCreateModal() {

        document.getElementById('createCategoryModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function closeModal(modalId) {

        document.querySelector(modalId).style.display = 'none';
        document.querySelector('.modal-overlay').style.display = 'none';
    }

    function closeAllModals() {
        closeModal('#createCategoryModal');
        closeModal('#editCategoryModal');
    }
</script>

</body>
</html>
