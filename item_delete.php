<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM item WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("Location: item_list.php");
    exit();
}

$conn->close();
?>