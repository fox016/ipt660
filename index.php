<?php

// Database information needed to connect
$dbname = "natefoxc_660db"; // Name of the DB
$dbuser = "natefoxc_660user"; // Username
$dbpass = "660forthewin"; // Password
$dbhost = "localhost"; // Host (use localhost if DB server is running on web server, else use IP address or domain)

// Connect to database
$dsn = "mysql:host=$dbhost;dbname=$dbname"; // This is the DSN pattern for any MySQL connection
$pdo = new PDO($dsn, $dbuser, $dbpass); // This returns a PDO, which is used to talk to the MySQL DB

// Insert data from user (if we got any)
if(isset($_POST['event']))
{
  // This just converts blanks to NULLs
  // This will prevent NULL/blank data from being inserted for required fields
  foreach($_POST as $key => $value)
  {
    $_POST[$key] = strip_tags($value); // This will make it so I can't put HTML in the field
    if($value === "") {
      $_POST[$key] = NULL;
    }
  }

  // Insert stuff into DB
  $sql = "INSERT INTO cars (make, model, year, trim, color, vin) VALUES (?, ?, ?, ?, ?, ?)"; // Use ? where user input will go
  $statement = $pdo->prepare($sql); // This turns that PHP string of MYSQL code into something that MySQL can use
  $statement->execute(array($_POST['make'], $_POST['model'], $_POST['year'], $_POST['trim'], $_POST['color'], $_POST['vin'])); // This will do the insert and replace the ? with actual user input
}

// Get data from DB
$sql = "SELECT * FROM cars"; // This is a PHP string of MySQL code
$statement = $pdo->prepare($sql); // This turns that PHP string of MYSQL code into something that MySQL can use
$statement->execute(); // This actually runs the MySQL code on your MySQL DB
$cars = $statement->fetchAll(PDO::FETCH_ASSOC); // This will get the results of my SELECT statement and put it in an array of arrays

?>
<!DOCTYPE HTML>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- jquery library -->
  <script type='text/javascript' src='js/660.js'></script> <!-- my custom JS -->
  <link rel='stylesheet' type='text/css' href='css/660.css' /> <!-- my custom CSS -->
</head>
<body>
  <h1>
    My Cars
  </h1>
  <form method='POST' action='./'>
    <input type='hidden' name='event' value='addCarEvent' />
    <table id='carTable'>
      <thead><tr><th>ID</th><th>Make</th><th>Model</th><th>Year</th><th>Trim</th><th>Color</th><th>VIN</th><th>Action</th></tr></thead>
      <tbody>
      <?php
      // Use data from database to create HTML for page
      for($carIndex=0; $carIndex < count($cars); $carIndex++)
      {
        $car = $cars[$carIndex];
        echo "<tr><td>{$car['car_id']}</td><td>{$car['make']}</td><td>{$car['model']}</td><td>{$car['year']}</td><td>{$car['trim']}</td><td>{$car['color']}</td><td>{$car['vin']}</td><td></td></tr>";
      }
      ?>
        <tr>
          <td></td>
          <td><input type='text' name='make' placeholder='REQUIRED'></td>
          <td><input type='text' name='model' placeholder='REQUIRED'></td>
          <td><input type='number' name='year' placeholder='REQUIRED'></td>
          <td><input type='text' name='trim' placeholder='OPTIONAL'></td>
          <td><input type='text' name='color' placeholder='OPTIONAL'></td>
          <td><input type='text' name='vin' placeholder='OPTIONAL'></td>
          <td><button type='submit'>Add Car</button></td>
        </tr>
      </tbody>
    </table>
  </form>
</body>
</html>
