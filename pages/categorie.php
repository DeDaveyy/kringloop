<?php
require_once('../functions/categorie.crud.php');

$dbh = new Dbh();
$db = $dbh->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['createCategory'])) {
        $name = $_POST['categoryName'];
        $code = $_POST['categoryCode'];
        createCategorie($db, $name, $code);
    } elseif (isset($_POST['updateCategory'])) {
        $id = $_POST['id'];
        $name = $_POST['categoryName'];
        $code = $_POST['categoryCode'];
        updateCategorie($db, $id, $name, $code);
    } elseif (isset($_POST['confirmDelete'])) {
        $id = $_POST['id'];
        deleteCategorie($db, $id);
    }
}

$categories = readCategories($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add overlay styling */
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
    <h1>Categories</h1>

    <!-- Search bar -->
    <form class="form-inline mb-3">
        <div class="form-group mx-sm-3 mb-2">
            <label for="searchInput" class="sr-only">Search</label>
            <input type="text" class="form-control" id="searchInput" placeholder="Search by name or code">
        </div>
        <button type="button" class="btn btn-primary mb-2" onclick="searchCategories()">Search</button>
    </form>

    <!-- Display existing categories -->
    <ul class="list-group">
        <?php foreach ($categories as $category) : ?>
            <li class="list-group-item">
                <label>
                    <input type="radio" name="selectedCategory" value="<?php echo $category['id']; ?>">
                    <?php echo $category['categorie']; ?>
                </label>
                <span class="badge badge-secondary"><?php echo $category['code']; ?></span>
                <form method="post" action="categorie.php" class="float-right">
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditModal(this)">Edit</button>
                    <button type="submit" name="confirmDelete" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Button to open Create Category modal -->
    <button type="button" class="btn btn-success mt-3" onclick="openCreateModal()">Create Category</button>

    <!-- Create Category Modal -->
    <div class="modal" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#createCategoryModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating a category -->
                    <form method="post" action="categorie.php">
                        <div class="form-group">
                            <label for="categoryName">Category Name:</label>
                            <input type="text" class="form-control" name="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryCode">Category Code (max 3 characters):</label>
                            <input type="text" class="form-control" name="categoryCode" maxlength="3" required>
                        </div>
                        <button type="submit" name="createCategory" class="btn btn-success">Create Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#editCategoryModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing a category -->
                    <form method="post" action="categorie.php">
                        <input type="hidden" id="editCategoryId" name="id">
                        <div class="form-group">
                            <label for="editCategoryName">Category Name:</label>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="editCategoryCode">Category Code (max 3 characters):</label>
                            <input type="text" class="form-control" id="editCategoryCode" name="categoryCode" maxlength="3" required>
                        </div>
                        <button type="submit" name="updateCategory" class="btn btn-primary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal overlay -->
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
        var listItems = document.querySelectorAll('.list-group-item');

        listItems.forEach(function(item) {
            var categoryName = item.querySelector('label').innerText.toLowerCase();
            var categoryCode = item.querySelector('.badge').innerText.toLowerCase();

            if (categoryName.includes(searchInput) || categoryCode.includes(searchInput)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function openEditModal(button) {
        var listItem = button.closest('.list-group-item');
        var categoryId = listItem.querySelector('input[name="selectedCategory"]').value;
        var categoryName = listItem.querySelector('label').innerText;
        var categoryCode = listItem.querySelector('.badge').innerText;

        // Set values in the Edit Category Modal
        document.getElementById('editCategoryId').value = categoryId;
        document.getElementById('editCategoryName').value = categoryName;
        document.getElementById('editCategoryCode').value = categoryCode;

        // Open the Edit Category Modal
        document.getElementById('editCategoryModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function openCreateModal() {
        // Open the Create Category Modal
        document.getElementById('createCategoryModal').style.display = 'block';
        document.querySelector('.modal-overlay').style.display = 'block';
    }

    function closeModal(modalId) {
        // Close the modal
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
