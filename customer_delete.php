<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM customer WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: customer_list.php?message=Customer deleted successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>