<?php
// Database connection
$Servername = "localhost";
$Username = "root";
$Password = "";
$DBName = "pup_management";

// Create connection
$conn = new mysqli($Servername, $Username, $Password, $DBName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is set
if (isset($_POST['full_name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    // Get the form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    
    // Bind parameters to the prepared statement
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully. <a href='index.php'>Go back</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "All fields are required.";
}

// Close the database connection
$conn->close();
?>

