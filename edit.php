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
    $author = $_POST['author'];
    $bookName = $_POST['bookName'];
    $isbn = $_POST['isbn'];
    $popis = $_POST['popis'];
    $instanceBooks->updateBook($bookId, $author, $bookName, $isbn, $popis);
    header("Location: index.php"); // Po úspěšné aktualizaci přesměrování zpět na seznam knih
    exit();
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
<html>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head -->
    <?php include 'head.php'; ?>
</head>


<body>

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <div class="container mt-3">
        <h2 class="h2">Editace knihy</h2>
        <?php if ($bookToEdit): ?>
            <form action="edit.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($bookToEdit['id']); ?>">
                <input class="form-control my-2" name="author" type="text" value="<?php echo htmlspecialchars($bookToEdit['author']); ?>" placeholder="Zadejte jméno autora" />
                <input class="form-control my-2" name="bookName" type="text" value="<?php echo htmlspecialchars($bookToEdit['bookName']); ?>" placeholder="Zadejte název knihy" />
                <input class="form-control my-2" name="isbn" type="text" value="<?php echo htmlspecialchars($bookToEdit['isbn']); ?>" placeholder="Zadejte ISBN" />
                <textarea class="form-control my-2" name="popis" placeholder="Popis knihy"><?php echo htmlspecialchars($bookToEdit['popis']); ?></textarea>
                <input class="btn btn-primary my-2" type="submit" name="update" value="Aktualizovat" />
                <a class="btn btn-danger" href="edit.php?delete=<?php echo $bookToEdit['id']; ?>" onclick="return confirm('Opravdu chcete vymazat tuto knihu?');">Smazat</a>
            </form>
        <?php else: ?>
            <p>Žádná nebo neexistující kniha k editaci.</p>
        <?php endif; ?>