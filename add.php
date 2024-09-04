<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

if (isset($_POST['add'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $bookName = $_POST['bookName'];
    $isbn = $_POST['isbn'];
    $popis = $_POST['popis'];
    $instanceBooks->addBook($lastName, $firstName, $bookName, $isbn, $popis);
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Přidání knihy</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Evidence knih</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Přehled knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit.php">Výhledání knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Vkládání nových knich</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <h2 class="h2">Přidání nové knihy</h2>
    <form action="add.php" method="post">
                <input type="hidden" name="id" value="">
                <input class="form-control my-2" name="firstName" type="text" value="" placeholder="Zadejte jméno autora" required/>
                <input class="form-control my-2" name="lastName" type="text" value="" placeholder="Zadejte příjmení autora" required/>
                <input class="form-control my-2" name="bookName" type="text" value="" placeholder="Zadejte název knihy" required/>
                <input class="form-control my-2" name="isbn" type="text" value="" placeholder="Zadejte ISBN" required/>
                <input class="form-control my-2" name="popis" type="text" value="" placeholder="Zadejte popis"/>
                <input class="btn btn-primary my-2" type="submit" name="add" value="Přidat knihu" />
            </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>