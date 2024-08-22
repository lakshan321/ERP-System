<?php
include 'db_connect.php';

$sql = "SELECT DISTINCT it.item_name, cat.category AS item_category, subcat.sub_category AS item_subcategory, it.quantity
        FROM item it
        INNER JOIN item_category cat ON it.item_category = cat.id
        INNER JOIN item_subcategory subcat ON it.item_subcategory = subcat.id";

$result = $conn->query($sql);

echo "<h2>Item Report</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Item Subcategory</th>
                <th>Item Quantity</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['item_name'] . "</td>
                <td>" . $row['item_category'] . "</td>
                <td>" . $row['item_subcategory'] . "</td>
                <td>" . $row['quantity'] . "</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No items found.";
}

$conn->close();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
    <link rel="stylesheet" type="text/css" href="item_report.css"> <!-- Link to the CSS file -->
</head>
<body>