<?php
require_once "book.php";
$bookObj = new Book();
$search = "";
$search = $genre = "";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])) : "";
    $genre = isset($_GET["genre"])? trim(htmlspecialchars($_GET["genre"])) : "";
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Books</h1>
    
    <form action="" method="get">
        <form method="get">
        <label for="">Search:</label>
        <input type="search" name="search" id="search" value="<?= $search ?>">
        <select name="genre" id="genre">
            <option value="">All</option>
            <option value="History" <?= (isset($genre) && $genre == "History")? "selected":"" ?>>History</option>
            <option value="Fiction" <?= (isset($genre) && $genre == "Fiction")? "selected":"" ?>>Fiction</option>
            <option value="Science" <?= (isset($genre) && $genre == "Science")? "selected":"" ?>>Science</option>
        </select>
        <input type="submit" value="Search">
    </form>
    <button><a href="addbook.php">Add Book</a></button>
    <table border=1>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>Action</th>
        </tr>
        <?php
        $no = 1;
        foreach($bookObj->viewBook($search, $genre) as $book){
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $book["title"] ?></td>
            <td><?= $book["author"] ?></td>
            <td><?= $book["genre"] ?></td>
            <td><?= $book["publication_year"] ?></td>
            <td>
                <a href = 'editbook.php?id=<?= $book['id'] ?>'>Edit</a>
                <a href = 'deletebook.php?id=<?= $book['id'] ?>' oneclick="return confirm('<?= $message ?>')">Delete</a>
            </td>
           
            
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>