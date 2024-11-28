<?php

class Books
{
    private $dbConn;

    // konstruktor, vytvoří spojení s Db
    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }

    // getter pole všech knih
    public function getBooks() {
        $query = "SELECT * FROM books ORDER BY bookName ASC"; // Sort books alphabetically
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function searchBooks($keyword){
    $query = "SELECT * FROM books WHERE 
              bookName LIKE :keyword1 OR 
              author LIKE :keyword2 OR 
              isbn LIKE :keyword3
              ORDER BY bookName ASC";
    $stmt = $this->dbConn->prepare($query);
    $stmt->bindValue(':keyword1', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':keyword2', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':keyword3', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getBook($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id ORDER BY bookName ASC";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBook($id, $author, $bookName, $isbn, $popis)
    {
        $sql = "UPDATE books SET author = :author, bookName = :bookName, isbn = :isbn, popis = :popis WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':popis', $popis, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Metoda pro přidání nové knihy
    public function addBook($author, $bookName, $isbn, $popis)
    {
        $sql = "INSERT INTO books (author, bookName, isbn, popis) VALUES (:author, :bookName, :isbn, :popis)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':popis', $popis, PDO::PARAM_STR);
        return $stmt->execute();
    }
}