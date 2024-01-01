<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:../unauthorized.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/result.css">
    <link rel="shortcut icon" href="../assets/seo.png" type="image/x-icon">
    <title>Search</title>
</head>

<body>
    <?php
    function drawTable($row_new, $query_new)
    {
        $numColumns = mysqli_num_fields($query_new);

        echo '<table style="width: 96px;">';
        echo '<tr>';
        for ($i = 0; $i < $numColumns; $i++) {
            $fieldName = mysqli_fetch_field_direct($query_new, $i)->name;
            if ($fieldName !== "car_id") {
                echo "<th>$fieldName</th>";
            }
        }
        echo '</tr>';
        $id = 0;
        // <form action='../car_details.php' method ='get' onclick='return check(row_new['car_status'])'>
        do {
            if ($row_new != null) {
                echo '<tr>';
                foreach ($row_new as $fieldName => $columnValue) {
                    if ($fieldName == "car_id") {
                        $id = $row_new['car_id'];
                        
                    }
                    if ($fieldName !== "car_id") {
                        if (str_contains($columnValue, "assets")) {
                            $width = 130;
                            $height = 100;
                            echo "<td><img src='../{$row_new['image']}' alt='photo' width='{$width}' height='{$height}' >
                            
                            <button class='car-image' name='car-details' onclick='gotoCar($id)'> Rent Car </button>
                                
                            </td>";
                        } else {
                            echo "<td>$columnValue</td>";
                        }
                    }
                }
                echo '</tr>';
            } else {
                echo '<tr><td colspan="' . $numColumns . '">There is no such result match in the database</td></tr>';
            }
        } while ($row_new = mysqli_fetch_assoc($query_new));
    }
    function check($status)
    {
        if ($status == 'Available')
            return true;
        else {
            echo '<script>
                alert("Car is ' . $status . '. Choose another available car");
            </script>';
            return false;
        }
    }

    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbName = "car_rental";
    require_once('../class.php');
    // $user = unserialize($_SESSION["user"]);

    $con = mysqli_connect($serverName, $userName, $password, $dbName);
    if (mysqli_connect_errno()) {
        echo "Failed to conned";
        // exit();
    }

    if (isset($_POST['search1'])) {
        $inp = $_POST['text'];
        $query = mysqli_query(
            $con,
            "SELECT car.car_id,car.year, car.model, car.car_status, car.price_per_day, car.office_id,car.image
            FROM car
            WHERE '$inp' = `year` OR '$inp' = `car_status` OR '$inp' = `plate_id` OR model LIKE '%$inp%'
            OR '$inp' = `price_per_day`
            "
        );

        if ($query) {
            $row = mysqli_fetch_assoc($query);
            echo '<br>';
            echo '<br>';
            drawTable($row, $query);
        } else {
            echo '<br>';
            echo "Failed to Search";
        }
    } elseif (isset($_POST['search2'])) {
        $year = $_POST['year'];
        $model = $_POST['model'];
        $price_from = $_POST['price-from'];
        $price_to = $_POST['price-to'];
        $country = $_POST['country'];
        $state = $_POST['state'];

        $query = mysqli_query(
            $con,
            "SELECT  c.car_id,c.`year`,c.model,c.car_status,c.price_per_day,c.office_id,c.image
            FROM car as c
            JOIN OFFICE as o on o.office_id=c.office_id
            WHERE model LIKE '$model%' and `year`='$year' and price_per_day between '$price_from' and '$price_to' and country='$country' and `state`='$state' "
        );

        if ($query) {
            $row = mysqli_fetch_assoc($query);
            echo '<br>';
            echo '<br>';
            drawTable($row, $query);
        } else {
            echo '<br>';
            echo "Failed to Search";
        }
    }
    ?>

    <script>
        function gotoCar(number) {
            console.log("in function");
            window.location.href = "../car_details.php?num=" + number;
        }



        
    </script>
</body>

</html>