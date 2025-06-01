<?php
session_start();
if (!isset($_SESSION['username'])) {
    // not logged in; redirect back
    header('Location: index.html');
    exit;
}

// List of all AQI values
$aqiMap = [
    'Dhaka'                 => 165,
    'Chattogram'            => 120,
    'Sylhet'                => 95,
    'Rangpur'               => 165,
    'Rajshahi'              => 120,
    'Barishal'              => 95,
    'New York, USA'         => 75,
    'London, UK'            => 85,
    'Tokyo, Japan'          => 90,
    'Delhi, India'          => 210,
    'Beijing, China'        => 230,
    'Sydney, Australia'     => 60,
    'Paris, France'         => 80,
    'Dubai, UAE'            => 130,
    'Moscow, Russia'        => 105,
    'Rio de Janeiro, Brazil'=> 110,
    'Toronto, Canada'       => 70,
    'Berlin, Germany'       => 75,
    'Seoul, South Korea'    => 100,
    'Mexico City, Mexico'   => 155,
];

$selected = $_POST['cities'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Selected AQI Cities</title>
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
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    table th, table td {
      padding: 8px;
      border: 1px solid #ccc;
    }
    table thead {
      background-color: #1976d2;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-bar">
      <div class="username">User: <?php echo htmlspecialchars($_SESSION['username']); ?></div>
      <a href="index.html" class="logout">Logout</a>
    </div>

    <h2>Your Selected Cities & AQI</h2>

    <?php if (empty($selected)): ?>
      <p>No cities were selected.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>City</th>
            <th>AQI</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($selected as $city): 
            $citySafe = htmlspecialchars($city);
            $aqi = isset($aqiMap[$city]) ? $aqiMap[$city] : 'N/A';
          ?>
            <tr>
              <td><?php echo $citySafe; ?></td>
              <td><?php echo $aqi; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
