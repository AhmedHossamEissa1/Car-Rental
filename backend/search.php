<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result of search</title>
</head>
<body>

     <?php
        session_start();
        $serverName = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "car_rental";

        $con = mysqli_connect($serverName, $userName, $password, $dbName);
        if (mysqli_connect_errno()) {
            echo "Failed to conned";
            // exit();
        }

        if (isset($_POST['submit'])) {
            $inp = $_POST['text'];


            $query = mysqli_query($con, "SELECT * FROM car
             WHERE '$inp' = `year` OR '$inp' = `car_status` OR '$inp' = `plate_id` OR '$inp' = `model`
             OR '$inp' = `price_per_day`
             "
             );
            if ($query) {
                $row = mysqli_fetch_assoc($query);
                // $name = $row['name'];
                echo "row returned $row";
                
                echo '</h1>';
            } else {
                echo '<br>';
                echo "Failed to reach to the email and password";
            }
        }
     ?>
    
</body>
</html>