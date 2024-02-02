<?php 
include("../includes/leftheader.includes.php");
include("../classes/dbhn.class.php");

$sql = "SELECT * FROM categorie";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclusie van Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Categorie Overzicht</title>
</head>

<body>
    <div class="container mt-4">
        <h1>Categories</h1>

        <?php
        if ($result) {
            echo '<form action="process_selected_categories.php" method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['code'] . "</td>";
                echo "<td>" . $row['category_name'] . "</td>";
                echo '<td><input type="checkbox" name="selected_categories[]" value="' . $row['id'] . '"></td>';
                echo "</tr>";
            }

            echo '</tbody>
                    </table>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    </form>';
        } else {
            echo "No categories found.";
        }
        ?>

    </div>

    <!-- Inclusie van Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
