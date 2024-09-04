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
    public function getBooks()
    {
        $stmt = $this->dbConn->prepare("SELECT * FROM books");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterBooks($lastName, $firstName, $bookName, $isbn)
    {
        // Základní SQL dotaz
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];

        // Přidání podmínek pro filtraci podle parametrů
        if (!empty($firstName)) {
            $sql .= " AND firstName LIKE :firstName";
            $params[':firstName'] = '%' . $firstName . '%';
        }

        if (!empty($lastName)) {
            $sql .= " AND lastName LIKE :lastName";
            $params[':lastName'] = '%' . $lastName . '%';
        }
        
        if (!empty($bookName)) {
            $sql .= " AND bookName LIKE :bookName";
            $params[':bookName'] = '%' . $bookName . '%';
        }

        if (!empty($isbn)) {
            $sql .= " AND isbn LIKE :isbn";
            $params[':isbn'] = '%' . $isbn . '%';
        }

        // Příprava SQL dotazu
        $stmt = $this->dbConn->prepare($sql);

        // Bindování parametrů (pouze pokud byly parametry přidány)
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }

        // Vykonání SQL dotazu
        $stmt->execute();

        // Návrat výsledků jako pole asociativních polí
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
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBook($id, $firstName, $lastName, $bookName, $isbn, $popis)
    {
        $sql = "UPDATE books SET firstName = :firstName, lastName = :lastName, bookName = :bookName, isbn = :isbn, popis = :popis WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':popis', $popis, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Metoda pro přidání nové knihy
    public function addBook($firstName, $lastName, $bookName, $isbn, $popis)
    {
        $sql = "INSERT INTO books (firstName, lastName, bookName, isbn, popis) VALUES (:firstName, :lastName, :bookName, :isbn, :popis)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':bookName', $bookName, PDO::PARAM_STR);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':popis', $popis, PDO::PARAM_STR);
        return $stmt->execute();
    }
}