<?php
session_start();
$price = $_GET['num'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Car Rental Payment</title>
  <link rel="stylesheet" href="../css/payment.css">
</head>

<body>
  <div class="container">
    <h2>Car Rental Payment</h2>
    <form method="post">
      <label for="pickup_date">Pickup Date:</label>
      <input type="date" id="pickup_date" name="pickup_date" required><br><br>

      <label for="return_date">Return Date:</label>
      <input type="date" id="return_date" name="return_date" required>

      <button type="submit" name="calculate" class="calculate-btn">Calculate Price</button>
      <?php
      // // Database connection
      // require_once("../config.php");

      // // Create connection
      // $conn = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);

      // // Check connection
      // if ($conn->connect_error) {
      //     die("Connection failed: " . $conn->connect_error);
      // }

      if (isset($_POST['calculate'])) {
        $start_date = new DateTime($_POST['pickup_date']);
        $end_date = new DateTime($_POST['return_date']);

        // $sql = "SELECT price_per_day FROM car
        // WHERE car_id='1' ";
        // $result = $conn->query($sql);

        // if ($result->num_rows > 0) {
        //     $row = $result->fetch_assoc();
        //     $price_per_day = $row['price_per_day'];

        // Calculate the difference between dates
        $interval = $start_date->diff($end_date);
        $days = $interval->days + 1; // Adding 1 day to include both start and end dates

        // $total_salary = $days * $price_per_day;
        $total_salary = $days * $price;

        echo "<br>Total Salary: $" . $total_salary . "</br>";
        echo "<p>Number of days: " . $days . "</p>";
      } else {
        echo "No data found";
      }
      ?>
      <br>


      <label for="visanumber">Enter Your Visa Number:</label>
      <input style="height: 30px;" type="number" id="visanumber" name="visanumber"><br>


      <form action="home.php" method="post"><button type="submit" name="pay" class="pay-btn">Pay</button></form>




    </form>

    <div class="payment-options">
      <img src="../assets/visa.png" alt="Visa" class="payment-img">
      <img src="../assets/fawry.png" alt="Fawry" class="payment-img">
    </div>
  </div>



  </div>



</body>

</html>