<?php
include 'db.php';
$searchQuery = '';
$filteredBooks = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchQuery = htmlspecialchars($_POST['search']);
    $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('ss', $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $filteredBooks = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
    $filteredBooks = $result->fetch_all(MYSQLI_ASSOC);
}

if (isset($_GET['action']) && isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
    if ($_GET['action'] == 'borrow') {
        $sql = "UPDATE books SET is_borrowed = 1 WHERE id = ?";
    } elseif ($_GET['action'] == 'unborrow') {
        $sql = "UPDATE books SET is_borrowed = 0 WHERE id = ?";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookId);
    $stmt->execute();
    header("Location: books.php");
    exit;
}
$books = 
[
    // Fiction
    ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'genre' => 'Fiction', 'year' => 1960],
    ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'genre' => 'Fiction', 'year' => 1925],
    ['title' => '1984', 'author' => 'George Orwell', 'genre' => 'Dystopian', 'year' => 1949],
    ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'genre' => 'Romance', 'year' => 1813],
    ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'genre' => 'Fiction', 'year' => 1951],
    ['title' => 'The Road', 'author' => 'Cormac McCarthy', 'genre' => 'Fiction', 'year' => 2006],
    ['title' => 'The Kite Runner', 'author' => 'Khaled Hosseini', 'genre' => 'Fiction', 'year' => 2003],
    ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'genre' => 'Fiction', 'year' => 1988],
    ['title' => 'The Picture of Dorian Gray', 'author' => 'Oscar Wilde', 'genre' => 'Fiction', 'year' => 1890],
    ['title' => 'Beloved', 'author' => 'Toni Morrison', 'genre' => 'Fiction', 'year' => 1987],

    // Dystopian
    ['title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury', 'genre' => 'Dystopian', 'year' => 1953],
    ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'genre' => 'Dystopian', 'year' => 1932],
    ['title' => 'The Handmaid\'s Tale', 'author' => 'Margaret Atwood', 'genre' => 'Dystopian', 'year' => 1985],
    ['title' => 'The Hunger Games', 'author' => 'Suzanne Collins', 'genre' => 'Dystopian', 'year' => 2008],
    ['title' => 'The Giver', 'author' => 'Lois Lowry', 'genre' => 'Dystopian', 'year' => 1993],
    ['title' => 'Station Eleven', 'author' => 'Emily St. John Mandel', 'genre' => 'Dystopian', 'year' => 2014],
    ['title' => 'Divergent', 'author' => 'Veronica Roth', 'genre' => 'Dystopian', 'year' => 2011],
    ['title' => 'Red Rising', 'author' => 'Pierce Brown', 'genre' => 'Dystopian', 'year' => 2014],
    ['title' => 'Never Let Me Go', 'author' => 'Kazuo Ishiguro', 'genre' => 'Dystopian', 'year' => 2005],
    ['title' => 'Cloud Atlas', 'author' => 'David Mitchell', 'genre' => 'Dystopian', 'year' => 2004],

    // Romance
    ['title' => 'Outlander', 'author' => 'Diana Gabaldon', 'genre' => 'Romance', 'year' => 1991],
    ['title' => 'The Notebook', 'author' => 'Nicholas Sparks', 'genre' => 'Romance', 'year' => 1996],
    ['title' => 'Me Before You', 'author' => 'Jojo Moyes', 'genre' => 'Romance', 'year' => 2012],
    ['title' => 'Gone with the Wind', 'author' => 'Margaret Mitchell', 'genre' => 'Romance', 'year' => 1936],
    ['title' => 'Brida', 'author' => 'Paulo Coelho', 'genre' => 'Romance', 'year' => 1990],
    ['title' => 'The Time Traveler\'s Wife', 'author' => 'Audrey Niffenegger', 'genre' => 'Romance', 'year' => 2003],
    ['title' => 'The Fault in Our Stars', 'author' => 'John Green', 'genre' => 'Romance', 'year' => 2012],
    ['title' => 'Eleanor & Park', 'author' => 'Rainbow Rowell', 'genre' => 'Romance', 'year' => 2012],
    ['title' => 'Red, White & Royal Blue', 'author' => 'Casey McQuiston', 'genre' => 'Romance', 'year' => 2019],

    // Adventure
    ['title' => 'The Adventures of Huckleberry Finn', 'author' => 'Mark Twain', 'genre' => 'Adventure', 'year' => 1884],
    ['title' => 'Moby-Dick', 'author' => 'Herman Melville', 'genre' => 'Adventure', 'year' => 1851],
    ['title' => 'The Three Musketeers', 'author' => 'Alexandre Dumas', 'genre' => 'Adventure', 'year' => 1844],
    ['title' => 'Life of Pi', 'author' => 'Yann Martel', 'genre' => 'Adventure', 'year' => 2001],
    ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'genre' => 'Adventure', 'year' => 1937],
    ['title' => 'Treasure Island', 'author' => 'Robert Louis Stevenson', 'genre' => 'Adventure', 'year' => 1883],
    ['title' => 'Into the Wild', 'author' => 'Jon Krakauer', 'genre' => 'Adventure', 'year' => 1996],
    ['title' => 'The Call of the Wild', 'author' => 'Jack London', 'genre' => 'Adventure', 'year' => 1903],
    ['title' => 'Around the World in Eighty Days', 'author' => 'Jules Verne', 'genre' => 'Adventure', 'year' => 1873],
    ['title' => 'Hatchet', 'author' => 'Gary Paulsen', 'genre' => 'Adventure', 'year' => 1986],

    // Non-Fiction
    ['title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'genre' => 'Non-Fiction', 'year' => 2011],
    ['title' => 'Educated', 'author' => 'Tara Westover', 'genre' => 'Non-Fiction', 'year' => 2018],
    ['title' => 'The Immortal Life of Henrietta Lacks', 'author' => 'Rebecca Skloot', 'genre' => 'Non-Fiction', 'year' => 2010],
    ['title' => 'Becoming', 'author' => 'Michelle Obama', 'genre' => 'Non-Fiction', 'year' => 2018],
    ['title' => 'The Wright Brothers', 'author' => 'David McCullough', 'genre' => 'Non-Fiction', 'year' => 2015],
    ['title' => 'Born a Crime', 'author' => 'Trevor Noah', 'genre' => 'Non-Fiction', 'year' => 2016],
    ['title' => 'The Diary of a Young Girl', 'author' => 'Anne Frank', 'genre' => 'Non-Fiction', 'year' => 1947],
    ['title' => 'Quiet: The Power of Introverts in a World That Can\'t Stop Talking', 'author' => 'Susan Cain', 'genre' => 'Non-Fiction', 'year' => 2012],
    ['title' => 'The Glass Castle', 'author' => 'Jeannette Walls', 'genre' => 'Non-Fiction', 'year' => 2005],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Books - Online Library Management System</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Nexus Library</h1>
        </div>
    </header>
    <center>
    <section class="book-search">
        <h2>Search for a Book</h2>
        <form action="books.php" method="post">
            <input type="text" name="search" placeholder="Search by title or author" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn">Search</button>
        </form>
    </section>
    <center>
    <section class="book-list">
        <h2>Available Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($filteredBooks)): ?>
                    <?php foreach ($filteredBooks as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['genre']); ?></td>
                            <td><?php echo htmlspecialchars($book['year']); ?></td>
                            <td>
                                <?php if (!$book['is_borrowed']): ?>
                                    <a href="borrow.php?book_id=<?php echo $book['id']; ?>" class="btn borrow-btn">Borrow</a>
                                <?php else: ?>
                                    <a href="books.php?action=unborrow&book_id=<?php echo $book['id']; ?>" class="btn unborrow-btn">Unborrow</a>
                                    <span class="borrowed">Borrowed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 Nexus Library. All rights reserved.</p>
    </footer>
    <script>
        document.querySelectorAll('.borrow-btn').forEach(button => {
            button.addEventListener('click', () => {
                alert('Book borrowed successfully!');
            });
        });
        document.querySelectorAll('.borrow-btn, .unborrow-btn').forEach(button => {
    button.addEventListener('click', () => {
        alert(button.textContent.trim() + ' action completed successfully!');
    });
});
    </script>
</body>
</html>


