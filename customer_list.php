<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="customer_list.css"> <!-- Link to the CSS file -->
    <title>Customer List</title>
    
</head>
<body>
<h2 style="text-align: center;">Customer List</h2>

<?php
include 'db_connect.php';

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT c.id, c.title, c.first_name, c.middle_name, c.last_name, c.contact_no, d.district 
        FROM customer c 
        INNER JOIN district d ON c.district = d.id
        WHERE c.first_name LIKE '%$search_query%' OR c.last_name LIKE '%$search_query%' OR d.district LIKE '%$search_query%'";
$result = $conn->query($sql);




if (isset($_GET['message'])) {
    echo "<p class='message'>" . $_GET['message'] . "</p>";
}

echo "<form action='customer_list.php' method='GET' class='search-form'>
        <input type='text' name='search' value='" . htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8') . "' class='search-input' placeholder='Search...'>
        <input type='submit' value='Search' class='search-button'>
      </form>";

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Title</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Contact No</th>
                <th>District</th>
                
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['middle_name'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['contact_no'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['district'], ENT_QUOTES, 'UTF-8') . "</td>
                <td class='actions'>
                    <a href='customer_form.php?id=" . $row['id'] . "'>Edit</a> | 
                    <a href='customer_delete.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No customers found.</p>";
}

$conn->close();
?>

</body>
</html>
