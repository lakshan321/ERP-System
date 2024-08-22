<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Form validation (e.g., check for empty fields) can be added here

    $sql = "INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price)
            VALUES ('$item_code', '$item_name', '$item_category', '$item_subcategory', '$quantity', '$unit_price')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to item_list.php with a success message
        header("Location: item_list.php?message=New item added successfully");
        exit();  // Make sure to exit after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
    <link rel="stylesheet" type="text/css" href="item_form.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h2 style="text-align: center;">Add Item</h2>
    <form method="POST" action="">
        Item Code: <input type="text" name="item_code" required><br>
        Item Name: <input type="text" name="item_name" required><br>
        Category:
        <select name="item_category" required>
            <?php
            $result = $conn->query("SELECT id, category FROM item_category");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
            }
            ?>
        </select><br>
        Subcategory:
        <select name="item_subcategory" required>
            <?php
            $result = $conn->query("SELECT id, sub_category FROM item_subcategory");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['sub_category'] . "</option>";
            }
            ?>
        </select><br>
        Quantity: <input type="number" name="quantity" required><br>
        Unit Price: <input type="number" step="0.01" name="unit_price" required><br>
        <input type="submit" value="Add Item">
    </form>
</body>
</html>
