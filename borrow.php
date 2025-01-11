<?php
include 'db.php';
if (isset($_GET['book_id'])) {
    $bookId = intval($_GET['book_id']);
    $sql = "UPDATE books SET is_borrowed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookId);
    if ($stmt->execute()) {
        echo "<script>alert('Book borrowed successfully!'); window.location.href='books.php';</script>";
    } else {
        echo "<script>alert('Failed to borrow the book.'); window.location.href='books.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
