<?php
require_once "Book.php";

$book = [
    "book" => "", "title" => "", "author" => "", "genre" => "","publication_year" => "","publisher" => "","copies" => ""];

$errors = [
    "book" => "","title" => "","author" => "","genre" => "","publication_year" => "","publisher" => "","copies" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["book"] = trim(htmlspecialchars($_POST["book"] ?? ""));
    $book["title"] = trim(htmlspecialchars($_POST["title"] ?? ""));
    $book["author"] = trim(htmlspecialchars($_POST["author"] ?? ""));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"] ?? ""));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"] ?? ""));
    $book["publisher"] = trim(htmlspecialchars($_POST["publisher"] ?? ""));
    $book["copies"] = trim(htmlspecialchars($_POST["copies"] ?? ""));

    
    if (empty($book["book"])) {
        $errors["book"] = "Book is required";
    }
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
    if (empty($book["copies"]) && $book["copies"] != "0") {
        $errors["copies"] = "Copies is required";
    } elseif (!is_numeric($book["copies"]) || $book["copies"] <= 0) {
        $errors["copies"] = "Copies must be a number greater than zero";
    }

    if (!array_filter($errors)) {
        $productObj = new Book();

        
        $productObj->book = $book["book"];
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
    <title>Add Book</title>
    <style>
        label { display: block; }
        span, .error { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <a href="viewbook.php">Back to List</a>

    
   <form action="" method="post">
    <label>Field with <span style="color:red">*</span> is required</label>
    
    <label for="book">Book Title <span style="color:red">*</span></label>
    <input type="text" name="book" id="book" value="<?= $book["book"] ?>">
    <p class="error"><?= $errors["book"] ?></p>

    <label for="author">Author <span style="color:red">*</span></label>
    <input type="text" name="author" id="author" value="<?= $book["author"] ?>">
    <p class="error"><?= $errors["author"] ?></p>

    <label for="genre">Genre <span style="color:red">*</span></label>
    <select name="genre" id="genre">
        <option value="">--Select--</option>
        <option value="history" <?= $book["genre"]=="history" ? "selected" : "" ?>>History</option>
        <option value="science" <?= $book["genre"]=="science" ? "selected" : "" ?>>Science</option>
        <option value="fiction" <?= $book["genre"]=="fiction" ? "selected" : "" ?>>Fiction</option>
    </select>
    <p class="error"><?= $errors["genre"] ?></p>

    <label for="publication_year">Publication Year <span style="color:red">*</span></label>
    <input type="number" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
    <p class="error"><?= $errors["publication_year"] ?></p>

    <label for="publisher">Publisher</label>
    <input type="text" name="publisher" id="publisher" value="<?= $book["publisher"] ?>">
    <p class="error"><?= $errors["publisher"] ?></p>

    <label for="copies">Copies <span style="color:red">*</span></label>
    <input type="number" name="copies" id="copies" value="<?= $book["copies"] ?>">
    <p class="error"><?= $errors["copies"] ?></p>

    <button type="submit">Add Book</button>
</form>
</body>
</html>
