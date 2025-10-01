<?php
require_once "database.php";
require_once "Book.php";

$bookObj = new Book();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["id"])) {
        $bid = trim(htmlspecialchars($_GET["id"]));
        $book = $bookObj->fetchBook($bid);
        
        if(!$book) {
            echo "<a href='viewbook.php'>View Book</a>";
            exit("Book not found");
        }
    } else {
        echo "<a href='viewbook.php'>View Book</a>";
        exit("Book not found");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bid = trim(htmlspecialchars($_POST["id"] ?? ""));
    
    if ($bookObj->deleteBook($bid)) {
        header("Location: viewbook.php");
        exit;
    } else {
        echo "Failed to delete book.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Book</title>
    <link rel="stylesheet" href="style.css">
    <style>
        label { display: block; margin-top: 10px; }
        span, .error { color: red; margin: 0; font-size: 14px; }
        .book-info { background: #f5f5f5; padding: 15px; margin: 20px 0; }
        .delete-warning { color: red; font-weight: bold; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Delete Book</h1>
    <a href="viewbook.php">Back to List</a>

    <div class="book-info">
        <h3>Book Details:</h3>
        <p><strong>Title:</strong> <?= htmlspecialchars($book["title"] ?? '') ?></p>
        <p><strong>Author:</strong> <?= htmlspecialchars($book["author"] ?? '') ?></p>
        <p><strong>Genre:</strong> <?= htmlspecialchars($book["genre"] ?? '') ?></p>
        <p><strong>Publication Year:</strong> <?= htmlspecialchars($book["publication_year"] ?? '') ?></p>
        <p><strong>Publisher:</strong> <?= htmlspecialchars($book["publisher"] ?? '') ?></p>
        <p><strong>Copies:</strong> <?= htmlspecialchars($book["copies"] ?? '') ?></p>
    </div>

    <div class="delete-warning">
        <p> Are you sure you want to delete this book? This action cannot be undone.</p>
    </div>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($book["id"] ?? '') ?>">
        
        <button type="submit" onclick="return confirm('Are you sure you want to delete this book?')" >Delete Book</button>
        <a href="viewbook.php" style="padding: 10px 20px; background: #ddd; color: black; text-decoration: none;">Cancel</a>
    </form>
</body>
</html>