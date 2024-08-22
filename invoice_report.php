<?php
include 'db_connect.php';

$customers = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM customer");

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$customer_id = isset($_GET['customer']) ? $_GET['customer'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Item Report</title>
</head>
<body>
    <h1>Invoice Item Report</h1>
    <form method="GET" action="">
        Start Date: <input type="date" name="start_date" required><br>
        End Date: <input type="date" name="end_date" required><br>

        <div class="form-group">
            <label for="customer">Customer:</label>
            <select name="customer" id="customer" required>
                <?php while ($row = $customers->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <input type="submit" value="Generate Report">
    </form>

    <?php
    if ($start_date && $end_date && $customer_id) {
        $sql = "
            SELECT 
                i.invoice_no,
                i.date AS invoice_date,
                CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                it.item_name,
                it.item_code,
                ic.category AS item_category,
                im.unit_price
            FROM 
                invoice i
            JOIN 
                customer c ON i.customer = c.id
            JOIN 
                invoice_master im ON i.invoice_no = im.invoice_no
            JOIN 
                item it ON im.item_id = it.id
            JOIN 
                item_category ic ON it.item_category = ic.id
            WHERE 
                i.date BETWEEN '$start_date' AND '$end_date'
            AND 
                i.customer = '$customer_id';
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                <tr>
                    <th>Invoice Number</th>
                    <th>Invoiced Date</th>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Item Category</th>
                    <th>Item Unit Price</th>
                </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['invoice_no']}</td>
                    <td>{$row['invoice_date']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['item_name']}</td>
                    <td>{$row['item_code']}</td>
                    <td>{$row['item_category']}</td>
                    <td>{$row['unit_price']}</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No records found for the selected date range and customer.";
        }
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>