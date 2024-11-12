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
if (isset($_POST['email'], $_POST['password'])) {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);  // "s" means string

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User found, fetch user data
        $row = $result->fetch_assoc();

        // Check if user is locked out
        if ($row['failed_attempts'] >= 3) {
            // Check if 'last_failed_at' is NULL, if so skip lockout check
            if ($row['last_failed_at'] !== NULL) {
                // Convert last_failed_at to timestamp (if it's not NULL)
                $last_failed = strtotime($row['last_failed_at']);
                $current_time = time();
                $time_diff = $current_time - $last_failed;

                // Lockout period (30 seconds)
                if ($time_diff < 30) {
                    // User is locked out, notify them and exit
                    $remaining_time = 30 - $time_diff;
                    echo "Too many failed attempts. Please try again in $remaining_time seconds. <a href='index.php'>Go back</a>";
                    exit(); // Stop further execution of the script
                } else {
                    // Reset failed attempts after lockout period has passed
                    $stmt_reset = $conn->prepare("UPDATE users SET failed_attempts = 0 WHERE email = ?");
                    $stmt_reset->bind_param("s", $email);
                    $stmt_reset->execute();
                }
            } else {
                // If `last_failed_at` is NULL, no failed attempts yet, so let the user try
                echo "Invalid password. <a href='index.php'>Go back</a>";
                exit();
            }
        }

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Successful login, reset failed attempts
            $stmt_reset = $conn->prepare("UPDATE users SET failed_attempts = 0 WHERE email = ?");
            $stmt_reset->bind_param("s", $email);
            $stmt_reset->execute();

            // Output a welcome message
            echo "Welcome, " . htmlspecialchars($row['full_name']) . ". You are now logged in. <a href='index.php'>Go back</a>";
        } else {
            // Incorrect password, increment failed attempts
            $stmt_failed = $conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_at = NOW() WHERE email = ?");
            $stmt_failed->bind_param("s", $email);
            $stmt_failed->execute();

            echo "Invalid password. <a href='index.php'>Go back</a>";
        }
    } else {
        echo "No user found with this email. <a href='index.php'>Go back</a>";
    }

    // Close statement
    $stmt->close();
} else {
    // Handle case when form data is not submitted
    echo "Please enter both email and password. <a href='index.php'>Go back</a>";
}

// Close the database connection
$conn->close();
?>
