<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="result">
    <?php

    function drawTable($row_new, $query_new)  //function to draw tables
    {

        $numColumns = mysqli_num_fields($query_new); //get number of columns
        echo '<table style="width: 96px;%">';
        echo '<tr>';
        for ($i = 0; $i < $numColumns; $i++) {
            $fieldName = mysqli_fetch_field_direct($query_new, $i)->name;
            echo "<th>$fieldName</th>";
        }
        echo '</tr>';

        do {
            if ($row_new != Null) {
                echo '<tr>';
                foreach ($row_new as $columnValue) {
                    echo "<th>$columnValue</th>";
                }
                echo '</tr>';
            } else {
                echo '<There is no such result match in database';
            }
        } while ($row_new = mysqli_fetch_assoc($query_new));   //put all rows in table

    }



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

    if (isset($_POST['search1'])) {
        $inp = $_POST['text'];
        $query = mysqli_query(
            $con,
            "SELECT car.year,car.model,car.car_status,car.price_per_day,car.office_id
                    FROM car
                    WHERE '$inp' = `year` OR '$inp' = `car_status` OR '$inp' = `plate_id` OR '$inp' = `model`
                    OR '$inp' = `price_per_day`
                    "
        );
        if ($query) {
            $row = mysqli_fetch_assoc($query);
            echo "result of search: ";
            echo '<br>';
            drawTable($row, $query);
        } else {
            echo '<br>';
            echo "Failed to reach to the email and password";
        }
    }

    ?>
    </div>
</body>

</html>