<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    if (!empty($fullname) && !empty($email) && !empty($_POST['password']) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn = new mysqli("localhost", "root", "", "mjglobaltech");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $password);
        
        if ($stmt->execute()) {
            echo "Signup successful! You can now login.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields correctly.";
    }
}
?>
