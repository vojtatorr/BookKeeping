<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();
// $selBookss = $books;

if (isset($_GET['lastName']) || isset($_GET['firstName']) || isset($_GET['bookName']) || isset($_GET['isbn'])) {
    $sellastName = $_GET['lastName'];
    $selfirstName = $_GET['firstName'];
    $selbookName = $_GET['bookName'];
    $selisbn = $_GET['isbn'];

    $selBooks = $instanceBooks->filterBooks($sellastName, $selfirstName, $selbookName, $selisbn);
} else {
    $selBooks = $books;
}

// Zpracování mazání knih
if (isset($_GET['delete'])) {
    $bookId = $_GET['delete'];
    $instanceBooks->deleteBook($bookId);
    header("Location: index.php");
    exit();
}

?>


<!-- HTML -->
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Evidence knih</title>
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
                        <a class="nav-link" href="edit.php">Editace knihy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Vkládání nových knich</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="h2">Vyhledávání</h2>
        <form action="index.php" method="get">
            <input class="form-control my-2" name="firstName" type="text" placeholder="Zadejte jméno autora" />
            <input class="form-control my-2" name="lastName" type="text" placeholder="Zadejte příjmení autora" />
            <input class="form-control my-2" name="bookName" type="text" placeholder="Zadejte název knihy" />
            <input class="form-control my-2" name="isbn" type="text" placeholder="Zadejte ISBN" />
            <input class="btn btn-primary my-2" type="submit" placeholder="Odešli" />
        </form>
        <?php
        if (sizeof($selBooks) > 0) {

        ?>
            <table class="table">
                <tr>
                    <th>Jméno</th>
                    <th>Přijmení</th>
                    <th>Název</th>
                    <th>ISBN</th>
                    <th>Popis</th>

                    
                </tr>
                <?php foreach ($selBooks as $book): ?>
                    <tr>
                        <td><?php echo $book['firstName']; ?></td>
                        <td><?php echo $book['lastName']; ?></td>
                        <td><?php echo $book['bookName']; ?></td>
                        <td><?php echo $book['isbn']; ?></td>
                        <td><?php echo $book['popis']; ?></td>
                        <td>
                            <a class="btn btn-warning" href="edit.php?id=<?php echo $book['id']; ?>">Editovat</a>
                            <a class="btn btn-warning" href="index.php?delete=<?php echo $book['id']; ?>" onclick="return confirm('Opravdu chcete vymazat tuto knihu?');">Smazat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php
        } else { ?>
            <p>Žádné knihy k zobrazení</p>
        <?php
        }
        ?>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>