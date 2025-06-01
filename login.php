<?php
session_start();
header('Content-Type: application/json'); // Return JSON response

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "registration_db";
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Database connection failed"]));
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

$response = ["success" => false, "error" => "Invalid email or password."];

if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $response = ["success" => true, "redirect" => "request.php"];
    }
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>