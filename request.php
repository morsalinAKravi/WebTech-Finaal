<?php
session_start();
// For demo purpose only
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'DemoUser';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Select Cities</title>
  <style>
    body {
      margin: 0;
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: white;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
   
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .top-bar .username {
      font-weight: bold;
    }
    .top-bar a.logout {
      text-decoration: none;
      color: #1976d2;
      font-weight: bold;
    }
    h2 {
      margin: 10px 0 20px;
      color: #1976d2;
    }
    .cities-list {
      column-count: 1;
      margin-bottom: 20px;
    }
    .cities-list label {
      display: block;
      margin-bottom: 6px;
    }
    button {
      padding: 10px 16px;
      background-color: #1976d2;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }
    .note {
      font-size: 14px;
      color: #555;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-bar">
      <div class="username">User: <?php echo htmlspecialchars($_SESSION['username']); ?></div>
      <a href="index.html" class="logout">Logout</a>
    </div>

    <h2>Select the City</h2>
    <div class="note">You must select exactly 10 cities to continue.</div>

    <form action="showaqi.php" method="post" id="cityForm">
      <div class="cities-list">
        <?php
        $cities = [
          'Dhaka','Chattogram','Sylhet','Rangpur','Rajshahi','Barishal',
          'New York, USA','London, UK','Tokyo, Japan','Delhi, India',
          'Beijing, China','Sydney, Australia','Paris, France',
          'Dubai, UAE','Moscow, Russia','Rio de Janeiro, Brazil',
          'Toronto, Canada','Berlin, Germany','Seoul, South Korea',
          'Mexico City, Mexico'
        ];
        foreach ($cities as $city) {
          $safe = htmlspecialchars($city);
          echo "<label><input type=\"checkbox\" name=\"cities[]\" value=\"$safe\"> $safe</label>";
        }
        ?>
      </div>
      <button type="submit" id="submitBtn" disabled>Submit Selection</button>
    </form>
  </div>

  <script>
    const maxAllowed = 10;
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="cities[]"]');
    const submitBtn = document.getElementById('submitBtn');

    function updateState() {
      const checkedCount = document.querySelectorAll('input[name="cities[]"]:checked').length;

      checkboxes.forEach(chk => {
        if (checkedCount >= maxAllowed && !chk.checked) {
          chk.disabled = true;
        } else {
          chk.disabled = false;
        }
      });

      // Only enable submit button when exactly 10 cities are selected
      submitBtn.disabled = (checkedCount !== maxAllowed);
    }

    checkboxes.forEach(chk => chk.addEventListener('change', updateState));
    document.addEventListener('DOMContentLoaded', updateState);
  </script>
</body>
</html>
