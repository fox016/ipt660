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
if(isset($_POST['event']) && $_POST['event'] === "addCarEvent")
{
  // This loop will turn all blanks into NULL
  foreach($_POST as $key => $value)
  {
    if($_POST[$key] === "") {
      $_POST[$key] = NULL;
    }
  }

  // Insert data into database
  $sql = "INSERT INTO cars (make, model, year, trim, color, vin) VALUES (?, ?, ?, ?, ?, ?)"; // This is a PHP string of MySQL code with ? where user input will go
  $statement = $pdo->prepare($sql); // This takes a MySQL string as input and returns a PDOStatement - a MySQL statement that can run on the MySQL DB
  $statement->execute(array($_POST['make'], $_POST['model'], $_POST['year'], $_POST['trim'], $_POST['color'], $_POST['vin'])); // This executes the PDOStatement and replaces the ? with user input
}

// Get data from database
$sql = "SELECT * FROM cars ORDER BY make ASC, model ASC, year DESC"; // This is a PHP string of MySQL code
$statement = $pdo->prepare($sql); // This takes a MySQL string as input and returns a PDOStatement - a MySQL statement that can run on the MySQL DB
$statement->execute(); // This executes the PDOStatement - it executes the MySQL code on the MySQL DB
$cars = $statement->fetchAll(PDO::FETCH_ASSOC); // This can be used after a SELECT statement is executed to get the results of the SELECT statement

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
      foreach($cars as $index => $car)
      {
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
