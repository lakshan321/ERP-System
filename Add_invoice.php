<?php
include 'db_connect.php';

// Fetch customers for the dropdown
$customers = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM customer");

// Fetch items for the dropdown
$items = $conn->query("SELECT id, item_name, unit_price FROM item");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer'];
    $item_ids = $_POST['items'];
    $quantities = $_POST['quantities'];
    $total_amount = 0;
    $invoice_items = [];
    $invoice_no = "INV" . rand(1000, 9999); // Example invoice number
    $invoice_date = date('Y-m-d');
    
    // Fetch customer details including the district
    $customer = $conn->query("SELECT first_name, last_name, district FROM customer WHERE id = $customer_id")->fetch_assoc();
    $customer_name = $customer['first_name'] . " " . $customer['last_name'];
    $customer_district = $customer['district'];

    // Calculate the total amount and item count
    foreach ($item_ids as $index => $item_id) {
        $quantity = $quantities[$index];
        $item = $conn->query("SELECT item_name, unit_price FROM item WHERE id = $item_id")->fetch_assoc();
        $amount = $item['unit_price'] * $quantity;
        $total_amount += $amount;
        $invoice_items[] = [
            'item_name' => $item['item_name'],
            'quantity' => $quantity,
            'unit_price' => $item['unit_price'],
            'amount' => $amount
        ];
    }
    $item_count = count($invoice_items); // Total number of items in the invoice
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
    <link rel="stylesheet" href="invoice_report.css">
</head>
<body>
   <h2 style="text-align: center;">Add invoice</h2>
    <div class="form-container">
        <form method="POST" action="">
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

            <div id="items-container">
                <div class="form-group">
                    <label for="items">Select Item:</label>
                    <select name="items[]" class="item-select" required>
                        <?php while ($row = $items->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>" data-price="<?php echo $row['unit_price']; ?>">
                                <?php echo $row['item_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantities[]" class="quantity-input" required>
                </div>
            </div>

            <div class="form-group">
                <button type="button" id="add-item">Add Another Item</button>
            </div>

            <div class="form-group">
                <input type="submit" value="Generate invoice">
            </div>
        </form>

        <?php if (isset($invoice_items)) { ?>
            <h3>Invoice view list</h3>
            <table>
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Customer District</th>
                        <th>Item Count</th>
                        <th>Invoice Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $invoice_no; ?></td>
                        <td><?php echo $invoice_date; ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_district; ?></td>
                        <td><?php echo $item_count; ?></td>
                        <td><?php echo $total_amount; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <script>
        document.getElementById('add-item').addEventListener('click', function () {
            const itemSelect = document.querySelector('.item-select').cloneNode(true);
            const quantityInput = document.querySelector('.quantity-input').cloneNode();
            quantityInput.value = '';
            const container = document.createElement('div');
            container.className = 'form-group';
            container.appendChild(itemSelect);
            container.appendChild(quantityInput);
            document.getElementById('items-container').appendChild(container);
        });
    </script>
</body>
</html>