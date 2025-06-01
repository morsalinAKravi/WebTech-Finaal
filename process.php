<?php
// Database connection
$host     = "localhost";
$db_user  = "root";
$db_pass  = "";
$db_name  = "registration_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$name      = $_POST['name']      ?? '';
$email     = $_POST['email']     ?? '';
$gender    = $_POST['gender']    ?? '';
$location  = $_POST['location']  ?? '';
$dob       = $_POST['date']      ?? '';
$password  = $_POST['password']  ?? '';
$bgColor   = $_POST['bgColorPicker'] ?? '#f5f5f5';

// If confirm button was clicked
if (isset($_POST['confirm'])) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, gender, location, dob, password, bgColor)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $name, $email, $gender, $location, $dob, $hashed_password, $bgColor);

    if ($stmt->execute()) {
        setcookie('bgColor', $bgColor, time() + (60 * 60 * 24 * 30), "/");
        header("Location: index.html?bgColor=" . urlencode($bgColor));
        exit();
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Confirmation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: <?php echo isset($_COOKIE['bgColor']) ? $_COOKIE['bgColor'] : '#f5f5f5'; ?>;
      transition: background-color 0.3s ease;
    }
    .confirmation-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #1976d2;
      text-align: center;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    .info-table th, .info-table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    .info-table th {
      background-color: #f2f2f2;
    }
    .button-container {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    .button {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .cancel-button {
      background-color: #f44336;
      color: white;
    }
    .confirm-button {
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>
<body>
  <div class="confirmation-container">
    <h1>Registration Information</h1>
    
    <table class="info-table">
      <tr>
        <th>Field</th>
        <th>Value</th>
      </tr>
      <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($_POST['name'] ?? ''); ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo htmlspecialchars($_POST['email'] ?? ''); ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo htmlspecialchars($_POST['gender'] ?? ''); ?></td>
      </tr>
      <tr>
        <td>Location</td>
        <td><?php echo htmlspecialchars($_POST['location'] ?? ''); ?></td>
      </tr>
      <tr>
        <td>Date of Birth</td>
        <td><?php echo htmlspecialchars($_POST['date'] ?? ''); ?></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><?php echo str_repeat('*', strlen($_POST['password'] ?? '')); ?></td>
      </tr>
      <tr>
        <td>Background Color</td>
        <td><?php echo htmlspecialchars($_POST['bgColorPicker'] ?? '#f5f5f5'); ?></td>
      </tr>
    </table>
    
    <div class="button-container">
  <form method="post" action="process.php">
   
    <input type="hidden" name="name"      value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    <input type="hidden" name="email"     value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    <input type="hidden" name="gender"    value="<?php echo htmlspecialchars($_POST['gender'] ?? ''); ?>">
    <input type="hidden" name="location"  value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>">
    <input type="hidden" name="date"      value="<?php echo htmlspecialchars($_POST['date'] ?? ''); ?>">
    <input type="hidden" name="password"  value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>">
    <input type="hidden" name="bgColorPicker" value="<?php echo htmlspecialchars($_POST['bgColorPicker'] ?? '#f5f5f5'); ?>">

  
    <button type="button" class="button cancel-button" onclick="window.history.back()">Cancel</button>

  
    <button type="submit" name="confirm" class="button confirm-button">Confirm</button>
  </form>
</div>


  <!-- <script>
    function confirmRegistration() {
      // Set cookie with the background color that expires in 30 days
      const bgColor = '<?php echo htmlspecialchars($_POST['bgColorPicker'] ?? '#f5f5f5'); ?>';
      document.cookie = `bgColor=${encodeURIComponent(bgColor)}; path=/; max-age=${60 * 60 * 24 * 30}`;
      
      // Redirect to index.html with color as URL parameter
      window.location.href = `index.html?bgColor=${encodeURIComponent(bgColor)}`;
    }
  </script> -->
</body>
</html>