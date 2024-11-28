<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();
// $selBookss = $books;

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $selBooks = $instanceBooks->searchBooks($keyword);
} else {
    $selBooks = $instanceBooks->getBooks();
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

    <div class="container">

        <div class="container m-2">
            <h2 class="h2">Vyhledávání</h2>
            <form action="index.php" method="get">
                <input class="form-control my-2" name="keyword" type="text" placeholder="Zadejte klíčové slovo" />
                <input class="btn btn-primary my-2" type="submit" value="Hledat" />
            </form>
        </div>

        <?php
        if (sizeof($selBooks) > 0) {

        
            foreach ($selBooks as $index => $book): ?>
                <!-- bookbox -->
                <div class="container bookbox">
                    <div class="row">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-12 align-items-center bookname">
                                    <?php echo $book['bookName']; ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-6 align-items-center author">
                                    <?php echo $book['author']; ?>
                                </div>
                                <div class="col-5 align-items-center isbn">
                                    <?php echo $book['isbn']; ?>
                                </div>
                                <div class="col-1 align-items-center">
                                    <button 
                                        class="btn btn-primary btn-sm" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse-<?php echo $index; ?>" 
                                        aria-expanded="false" 
                                        aria-controls="collapse-<?php echo $index; ?>">
                                        Popis
                                    </button>
                                </div>
                            </div>
            
                            <!-- Collapse container -->
                            <div class="collapse m-1 collapse-vertical" id="collapse-<?php echo $index; ?>">
                                <div class="card card-body" style="width: auto;">
                                    <?php echo $book['popis']; ?>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-1">
                            <a href="edit.php?id=<?php echo $book['id']; ?>" class="d-flex justify-content-center align-items-center btn btn-warning w-100 h-100">
                                <img src="img/settings-cog.png" alt="settings-cog" width="auto" height="auto">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

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