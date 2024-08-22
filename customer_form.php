<?php
include 'db_connect.php';

// Get districts for dropdown
$districts = $conn->query("SELECT id, district FROM district");

$id = isset($_GET['id']) ? $_GET['id'] : '';
$title = $first_name = $middle_name = $last_name = $contact_no = $district = '';

if ($id) {
    // Fetch existing customer data
    $stmt = $conn->prepare("SELECT * FROM customer WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $first_name = $row['first_name'];
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $contact_no = $row['contact_no'];
        $district = $row['district'];
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];

    if ($id) {
        // Update existing customer
        $stmt = $conn->prepare("UPDATE customer SET title=?, first_name=?, middle_name=?, last_name=?, contact_no=?, district=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $first_name, $middle_name, $last_name, $contact_no, $district, $id);
    } else {
        // Add new customer
        $stmt = $conn->prepare("INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $first_name, $middle_name, $last_name, $contact_no, $district);
    }

    if ($stmt->execute()) {
        header("Location: customer_list.php?message=Customer saved successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="customer_form.css"> <!-- Link to the CSS file -->
    <title>Customer Form</title>
    
    
</head>
<body>
    <h2 style="text-align: center;">Customer Registration</h2>
    <div class="form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title:</label>
                <select name="title" id="title" required>
                    <option value="Mr" <?php echo ($title == 'Mr') ? 'selected' : ''; ?>>Mr</option>
                    <option value="Mrs" <?php echo ($title == 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
                    <option value="Miss" <?php echo ($title == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                    <option value="Dr" <?php echo ($title == 'Dr') ? 'selected' : ''; ?>>Dr</option>
                </select>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name:</label>
                <input type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($middle_name); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact Number:</label>
                <input type="text" name="contact_no" id="contact_no" value="<?php echo htmlspecialchars($contact_no); ?>" required>
            </div>
            <div class="form-group">
                <label for="district">District:</label>
                <select name="district" id="district" required>
                    <?php while ($row = $districts->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($district == $row['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['district']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>
</html>
