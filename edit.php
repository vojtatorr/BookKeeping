<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$bookToEdit = [];

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $bookToEdit = $instanceBooks->getBook($bookId); // Načtení dat knihy k editaci
}

// Zpracování aktualizace knihy po odeslání formuláře
if (isset($_POST['update'])) {
    $bookId = $_POST['id'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $bookName = $_POST['bookName'];
    $isbn = $_POST['isbn'];
    $popis = $_POST['popis'];
    $instanceBooks->updateBook($bookId, $lastName, $firstName, $bookName, $isbn, $popis);
    header("Location: index.php"); // Po úspěšné aktualizaci přesměrování zpět na seznam knih
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Editace knihy</title>
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
        <h2 class="h2">Editace knihy</h2>
        <?php if ($bookToEdit): ?>
            <form action="edit.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($bookToEdit['id']); ?>">
                <input class="form-control my-2" name="firstName" type="text" value="<?php echo htmlspecialchars($bookToEdit['firstName']); ?>" placeholder="Zadejte jméno autora" />
                <input class="form-control my-2" name="lastName" type="text" value="<?php echo htmlspecialchars($bookToEdit['lastName']); ?>" placeholder="Zadejte příjméní autora" />
                <input class="form-control my-2" name="bookName" type="text" value="<?php echo htmlspecialchars($bookToEdit['bookName']); ?>" placeholder="Zadejte název knihy" />
                <input class="form-control my-2" name="isbn" type="text" value="<?php echo htmlspecialchars($bookToEdit['isbn']); ?>" placeholder="Zadejte ISBN" />
                <input class="form-control my-2" name="popis" type="text" value="<?php echo htmlspecialchars($bookToEdit['popis']); ?>" placeholder="Popis knihy" />
                <input class="btn btn-primary my-2" type="submit" name="update" value="Aktualizovat" />
            </form>
        <?php else: ?>
            <p>Žádná nebo neexistující kniha k editaci.</p>
        <?php endif; ?>