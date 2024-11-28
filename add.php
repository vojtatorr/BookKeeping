<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

if (isset($_POST['add'])) {
    $author = $_POST['author'];
    $bookName = $_POST['bookName'];
    $isbn = $_POST['isbn'];
    $popis = $_POST['popis'];
    $instanceBooks->addBook($author, $bookName, $isbn, $popis);
    header("Location: index.php");
    exit();
}
?>


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
    <h2 class="h2">Přidání nové knihy</h2>
    <form action="add.php" method="post">
                <input type="hidden" name="id" value="">
                <input class="form-control my-2" name="author" type="text" value="" placeholder="Zadejte jméno autora" required/>
                <input class="form-control my-2" name="bookName" type="text" value="" placeholder="Zadejte název knihy" required/>
                <input class="form-control my-2" name="isbn" type="text" value="" placeholder="Zadejte ISBN" required/>
                <textarea class="form-control my-2" name="popis" placeholder="Zadejte popis"></textarea>
                <input class="btn btn-primary my-2" type="submit" name="add" value="Přidat knihu" />
            </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>