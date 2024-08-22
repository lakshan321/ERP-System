<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>
    <link rel="stylesheet" href="item_list.css">
</head>
<body>
    <?php
    include 'db_connect.php';

    $search_query = "";
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
    }

    $sql = "SELECT i.id, i.item_code, i.item_name, c.category, s.sub_category, i.quantity, i.unit_price 
            FROM item i 
            INNER JOIN item_category c ON i.item_category = c.id 
            INNER JOIN item_subcategory s ON i.item_subcategory = s.id
            WHERE i.item_code LIKE '%$search_query%' OR i.item_name LIKE '%$search_query%' OR c.category LIKE '%$search_query%'";
    $result = $conn->query($sql);

    echo "<h2>Item List</h2>";
    echo "<form action='item_list.php' method='GET'>
            <input type='text' name='search' value='$search_query' placeholder='Search...'>
            <input type='submit' value='Search'>
          </form>";

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Actions</th>
                </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['item_code'] . "</td>
                    <td>" . $row['item_name'] . "</td>
                    <td>" . $row['category'] . "</td>
                    <td>" . $row['sub_category'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>" . $row['unit_price'] . "</td>
                    <td>
                        <a href='item_edit.php?id=" . $row['id'] . "'>Edit</a> | 
                        <a href='item_delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No items found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
