<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn = new mysqli("localhost", "root", "", "mjglobaltech");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $fullname, $hashed_password);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['fullname'] = $fullname;
                echo "Login successful! Welcome, " . $fullname;
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "User not found.";
        }
        
        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields correctly.";
    }
}
?>
