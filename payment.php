<?php
session_start();
if (empty($_SESSION["user"])) {
  header("location:unauthorized.php");
}
$id = $_GET['num'];
$price=$_GET['num1'];
$userid=$_GET['num2'];
$offid=$_GET['num3'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="assets/online-payment.png" type="image/x-icon">
  <title>Car Rental Payment</title>
  <link rel="stylesheet" href="css/payment.css">
</head>

<body>
  <div class="container">
    <h2>Car Rental Payment</h2>
    <form  method="post" id="form1" name="form1"  required onsubmit="return validateDates()" vaoninput="calculate()">
  
      <label for="pickup_date">Pickup Date:</label>
      <input type="date" id="pickup_date" name="pickup_date" required required oninput="calculate()"><br><br>

      <label for="return_date">Return Date:</label>
      <input type="date" id="return_date" name="return_date" required oninput="calculate()">
      <div id="date_info"></div>
   
     


     
      <br>

<div>
      <label for="toggleVisa" style="display: inline-block;">Pay at pickup</label>
<input style="margin-top: 0; display: inline-block;" type="checkbox" id="toggleVisa" onchange="toggleVisaInput()"></div>
<br>

<label for="visanumber">pay now:</label>
<input style="height: 30px;" type="number" id="visanumber" name="visanumber" required>
<br>

      <button type="submit" name="pay" class="pay-btn">Pay</button></form>

      <?php
 $conn= new mysqli("localhost","root","","car_rental");
if($conn->connect_error){
   die("connection failed".$conn->connect_error);
}
  if (isset($_POST['pay'])) {
    
    $pickupDate = $_POST['pickup_date'];
    $returnDate = $_POST['return_date'];
   
  
    if ($returnDate <= $pickupDate) {
      echo "<p>Return date must be greater than pickup date.</p>"; 
   
  }else{
    $sql1="SELECT reservation.*
    FROM reservation 
    WHERE car_id = '".$id."'
      AND (('".$pickupDate."'  BETWEEN pickup_date AND return_date) 
      or ('".$returnDate."'  BETWEEN pickup_date AND return_date)
       or (pickup_date  BETWEEN '".$pickupDate."'  AND '".$returnDate."') 
       or (return_date  BETWEEN '".$pickupDate."'  AND '".$returnDate."')) ;";
        $quer1=$conn->query($sql1);
   
      
 
    if ($quer1->num_rows == 0) //avilble car
    { if(empty($_POST['visanumber'])){
      $pickupDateTime = new DateTime($pickupDate);
      $returnDateTime = new DateTime($returnDate);

   $interval = $pickupDateTime->diff($returnDateTime);
    $numberOfDays = $interval->days;
      $visaNumber = $_POST['visanumber'];
      $current_time = date("Y-m-d H:i:s");
      $sql2="INSERT INTO reservation (reservation_date, pickup_date, return_date, admin_id, car_id, user_id, office_id)
      VALUES
          ('".$current_time."', '".$pickupDate."', '".$returnDate."',1 ,'".$id."' , '".$userid."', '".$offid."');";
       $quer2=$conn->query($sql2);
       $lastInsertedId = $conn->insert_id;
       $sql3="INSERT INTO payment (paymentstaus,remaining,reservation_id,payment_date)
       VALUES
       ('cash',$price*$numberOfDays,'".$lastInsertedId."','".$current_time."');";
       $quer3=$conn->query($sql3);
       header("Location: home.php");
       exit();
    }else{
      
      $current_time = date("Y-m-d H:i:s");
      $sql2="INSERT INTO reservation (reservation_date, pickup_date, return_date, admin_id, car_id, user_id, office_id)
      VALUES
          ('".$current_time."', '".$pickupDate."', '".$returnDate."',1 ,'".$id."' , '".$userid."', '".$offid."');";
       $quer2=$conn->query($sql2);
       $lastInsertedId = $conn->insert_id;
       $sql3="INSERT INTO payment (paymentstaus,remaining,reservation_id,payment_date)
       VALUES
       ('visa',0,'".$lastInsertedId."','".$current_time."');";
       $quer3=$conn->query($sql3);
       header("Location: home.php");
       exit();}

    }else{
      $row = $quer1->fetch_assoc();
      $p = $row['pickup_date'];
      $r = $row['return_date'];
      echo "<p>the car is reserved between ".$p." and ".$r."</p>";
    }

}

  



  
  } $conn->close();
  ?>


   

    <div class="payment-options">
      <img src="assets/visa.png" alt="Visa" class="payment-img">
      <img src="assets/fawry.png" alt="Fawry" class="payment-img">
     
    </div>
  </div>



  </div>

  <script>
        function validateDates() {
      var pickupDate = new Date(document.getElementById("pickup_date").value);
      var returnDate = new Date(document.getElementById("return_date").value);
       var currentTime = new Date();


  if (pickupDate < currentTime ) {

    alert("you have a time machine or what");
    return false;
  }

      if (returnDate <= pickupDate) {
        alert("Return date must be greater than pickup date");
        return false;
      }

      return true;
    }
  
    var id = <?php echo json_encode($id); ?>;
    var price = <?php echo json_encode($price); ?>;
    function calculate() {
  var pickupDateValue = document.getElementById("pickup_date").value;
  var returnDateValue = document.getElementById("return_date").value;

  if (!pickupDateValue || !returnDateValue || pickupDateValue>returnDateValue ) {
    
    var dateInfoDiv = document.getElementById("date_info");
    dateInfoDiv.innerHTML = ""; // Clear the content of dateInfoDiv
  } else {
    var pickupDate = new Date(pickupDateValue);
    var returnDate = new Date(returnDateValue);
    // Continue with your existing logic for calculating the price
    var timeDifference = returnDate - pickupDate;
    var daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));

    // Your price calculation logic here
    // For example, let's say the calculated price is stored in a variable named calculatedPrice
    var calculatedPrice = daysDifference * price;

    var dateInfoDiv = document.getElementById("date_info");
    dateInfoDiv.innerHTML = "Expected Price: $" + calculatedPrice.toFixed(2);
  }
}
function returnHome(number, number1) {
        window.location.href = "home.php" ;
    }
    function toggleVisaInput() {
    var toggleVisa = document.getElementById("toggleVisa");
    var visaNumberInput = document.getElementById("visanumber");

    if (toggleVisa.checked) {
        visaNumberInput.value = ""; // Clear the input
        visaNumberInput.disabled = true;
        visaNumberInput.removeAttribute("required");
    } else {
        visaNumberInput.disabled = false;
        visaNumberInput.setAttribute("required", "required");
    }
}
  </script>
</body>

</html>