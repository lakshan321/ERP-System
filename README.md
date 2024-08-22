--------- Overview --------------

This ERP system allows you to manage customer and item data, generate reports, and handle invoices. The system is built using PHP and MySQL, and it supports CRUD operations for customers and items, as well as various reports.

----------------- Assumptions -------------------

Local Development Environment: The setup use a local development environment XAMPP which includes PHP, MySQL, and Apache.

Database: The MySQL server is running locally with default settings.

Permissions: Have permission to create databases and tables on your MySQL server.

PHP Version: The project is compatible with PHP 8.2.12

Web Server: Apache is used as the web server.

MySQL Client: phpMyAdmin is used for database management.

------------------- Project Setup ----------------------------------

1. Set Up the Database

Create a New Database:
Open phpMyAdmin and create a new database named "".

Import Database Structure and Data:
Import the provided SQL files to set up the database tables and initial data.

2. Configure Database Connection
   Create db_connect.php and configure it with my local MySQL server credentials:

db_connect.php

<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "project1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

3. Run the Application

Start the Web Server:
Start Apache and MySQL from my local development environment XAMPP

Access the Application:
Open the web browser and navigate to http://localhost/project1/

4. Using this system

Customer Management: Go to "customer_form.php" to add new customers and view the list of customers at "customer_list.php"

Item Management: Go to "item_form.php" to add new items and view the list of items at "item_list.php"

Reports: Generate reports using "invoice_report.php", "invoice_item_report.php", and "item_report.php" by selecting the appropriate date ranges.
