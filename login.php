<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connection details
    $servername = "localhost";
    $username = "root";
    $password = ""; // Change this if needed
    $dbname = "user_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query to check if the username exists
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($inputPassword, $row['password'])) {
            $_SESSION['username'] = $inputUsername;
            header("Location: home.php");
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "No user found!";
    }

    $stmt->close();
    $conn->close();
}
?>

