<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM item WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "Item not found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    $sql = "UPDATE item SET item_code='$item_code', item_name='$item_name', item_category='$item_category', 
            item_subcategory='$item_subcategory', quantity='$quantity', unit_price='$unit_price' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Item updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: item_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="item_edit.css"> <!-- Link to the CSS file -->
    <title>Update Item</title>
    
</head>
<body>

<div class="container">
    <h2>Update Item</h2>
    <form method="POST" action="">
        <label for="item_code">Item Code:</label>
        <input type="text" id="item_code" name="item_code" value="<?php echo $item['item_code']; ?>" required>

        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" value="<?php echo $item['item_name']; ?>" required>

        <label for="item_category">Category:</label>
        <select id="item_category" name="item_category" required>
            <?php
            $result = $conn->query("SELECT id, category FROM item_category");
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $item['item_category']) ? "selected" : "";
                echo "<option value='" . $row['id'] . "' $selected>" . $row['category'] . "</option>";
            }
            ?>
        </select>

        <label for="item_subcategory">Subcategory:</label>
        <select id="item_subcategory" name="item_subcategory" required>
            <?php
            $result = $conn->query("SELECT id, sub_category FROM item_subcategory");
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $item['item_subcategory']) ? "selected" : "";
                echo "<option value='" . $row['id'] . "' $selected>" . $row['sub_category'] . "</option>";
            }
            ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $item['quantity']; ?>" required>

        <label for="unit_price">Unit Price:</label>
        <input type="number" step="0.01" id="unit_price" name="unit_price" value="<?php echo $item['unit_price']; ?>"required> 


        <input type="submit" value="Update Item">
    </form>
</div>

</body>
</html>