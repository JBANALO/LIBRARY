<?php
require_once "database.php";
require_once "Book.php";
$bookObj = new Book();

$book = [
    "title" => "", "author" => "", "genre" => "","publication_year" => "","publisher" => "","copies" => ""
];

$errors = [
    "title" => "","author" => "","genre" => "","publication_year" => "","publisher" => "","copies" => ""
];
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
    $book["title"] = trim(htmlspecialchars($_POST["title"] ?? ""));
    $book["author"] = trim(htmlspecialchars($_POST["author"] ?? ""));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"] ?? ""));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"] ?? ""));
    $book["publisher"] = trim(htmlspecialchars($_POST["publisher"] ?? ""));
    $book["copies"] = trim(htmlspecialchars($_POST["copies"] ?? ""));
    $bid = trim(htmlspecialchars($_POST["id"] ?? ""));

   
    if (empty($book["title"])) {
        $errors["title"] = "Title is required";
    }
    if (empty($book["author"])) {
        $errors["author"] = "Author is required";
    }
    if (empty($book["genre"])) {
        $errors["genre"] = "Please select a genre";
    }
    if (empty($book["publication_year"])) {
        $errors["publication_year"] = "Publication year is required";
    }
    if (empty($book["copies"])) {
        $errors["copies"] = "Copies is required";
    } elseif (!is_numeric($book["copies"]) || $book["copies"] <= 0) {
        $errors["copies"] = "Copies must be a number greater than zero";
    }

  
    if (!array_filter($errors)) {
        $productObj = new Book();
        $productObj->title = $book["title"];
        $productObj->author = $book["author"];
        $productObj->genre = $book["genre"];
        $productObj->publication_year = $book["publication_year"];
        $productObj->publisher = $book["publisher"];
        $productObj->copies = $book["copies"];

        if ($productObj->addBook()) {
            header("Location: viewbook.php");
            exit;
        } else {
            echo "Failed to add book.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
    <style>
        label { display: block; margin-top: 10px; }
        span, .error { color: red; margin: 0; font-size: 14px; }
    </style>
</head>
<body>
<h1>Edit Book</h1>
    <a href="viewbook.php">Back to List</a>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($book["id"] ?? '') ?>">
        
        <label>Fields with <span>*</span> are required</label>

        <label for="title">Book Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($book["title"] ?? '') ?>">
        <p class="error"><?= $errors["title"] ?></p>

        <label for="author">Author <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= htmlspecialchars($book["author"] ?? '') ?>">
        <p class="error"><?= $errors["author"] ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select--</option>
            <option value="History" <?= ($book["genre"] ?? '') == "History" ? "selected" : "" ?>>History</option>
            <option value="Science" <?= ($book["genre"] ?? '') == "Science" ? "selected" : "" ?>>Science</option>
            <option value="Fiction" <?= ($book["genre"] ?? '') == "Fiction" ? "selected" : "" ?>>Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="publication_year">Publication Year <span>*</span></label>
        <input type="number" name="publication_year" id="publication_year" value="<?= htmlspecialchars($book["publication_year"] ?? '') ?>">
        <p class="error"><?= $errors["publication_year"] ?></p>

        <label for="publisher">Publisher</label>
        <input type="text" name="publisher" id="publisher" value="<?= htmlspecialchars($book["publisher"] ?? '') ?>">
        <p class="error"><?= $errors["publisher"] ?></p>

        <label for="copies">Copies <span>*</span></label>
        <input type="number" name="copies" id="copies" value="<?= htmlspecialchars($book["copies"] ?? '') ?>">
        <p class="error"><?= $errors["copies"] ?></p>

        <button type="submit">Update Book</button>
    </form>
</body>
</html>