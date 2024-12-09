<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connection details
    $servername = "localhost";
    $username = "root";
    $password = ""; // Leave it empty if root has no password, or set it to the correct password
    $dbname = "user_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

    // Insert data into database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $inputUsername, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
