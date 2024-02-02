<?php 
    include("../includes/leftheader.php"); 
    include("../classes/dbh.class.php"); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclusie van Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Insert Data into Database</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card">
                    <div class="card-header">
                        <!-- Koptekst van de kaart met een koppeling om terug te gaan naar de indexpagina -->
                        <h3> Insert Data into Database
                            <a href="index.php" class="btn btn-primary float-end">Back</a>
                        </h3>
                    </div>
                    <div class="card-body">

                        <!-- Display success or error message if available -->
                        <?php
                        session_start();
                        if (isset($_SESSION['message'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                            unset($_SESSION['message']); // Clear the message to avoid displaying it again
                        }
                        ?>

                        <!-- Formulier voor het invoeren van studentengegevens -->
                        <form action="" method="POST">
                            <div class="mb-3">
                                <!-- Invoerveld voor de volledige naam -->
                                <label>Categorie</label>
                                <input type="text" name="categorie" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <!-- Knop om het studentenrecord op te slaan -->
                                <button type="submit" name="save_category_btn" class="btn btn-primary">Save category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php  if (isset($_POST['save_category_btn'])) {
    // Haal de benodigde gegevens op uit de POST-variabelen
    $categorie = $_POST['categorie'];

    try {
        // Voorbereid SQL-query om een student toe te voegen
        $query = "INSERT INTO categorie (categorie) VALUES (:categorie)";
        $statement = $conn->prepare($query);

        // Bind de parameters en voer de query uit
        $data = [
            ':categorie' => $categorie,
        ];

        $query_execute = $statement->execute($data);

        // Controleer of de query met succes is uitgevoerd en stel een sessiebericht in
        if ($query_execute) {
            $_SESSION['message'] = "Student added successfully";
        } else {
            $_SESSION['message'] = "Failed to add student";
        }
    } catch (PDOException $e) { 
        echo "<div> Error" . $e->getMessage() . "</div>";
    }
}
        ?>
        

    <!-- Inclusie van Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>