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
    <link rel="shortcut icon" href="../assets/admin.png" type="image/x-icon">
    <title>Admin page</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>




    <nav>
        <img src="../assets/vendor-8.png" alt="Company Logo" class="logo">
        <button onclick="logout()">LOGOUT</button>

    </nav>

    <br><br><br><br>





    <div class="grid-container">
        <aside>
            <form id="submit" action="admin.php" method="post"> <!-- make admin.php to handle requests-->
                <span class="menu-text">ADMIN MENU</span>
                <ul class="box">

                    <li>1- All reservations (including all car and <br> customer information) in specified period


                    </li>
                    <label>From:</label>
                    <input id="d1" class="date" type="date" name="date1">
                    <label>To:</label>
                    <input id="d2" class="date" type="date" name="date2">
                    <li>2- All reservations (including all car <br> information) in specified period

                    </li>
                    <label>From:</label>
                    <input id="d3" class="date" type="date" name="date3">
                    <label>To:</label>
                    <input id="d4" class="date" type="date" name="date4">
                    <li>3- The status of all cars in specified day

                        <label>DAY </label>
                        <input id="d5" class="date" type="date" name="date5">
                    </li>

                    <li>4- All reservations of specific customer


                        <input class="co-no" type="number" name="cus_no" placeholder="customer ID" style="width: 140px;">
                    </li>

                    <li>5- Daily payments within specific period in <br> specified period

                        <label>From:</label>
                        <input id="d6" class="date" type="date" name="date6">
                        <label>To:</label>
                        <input id="d7" class="date" type="date" name="date7">
                    </li>

                </ul>
                <input class="go" type="submit" value="Get result" name="submit">

            </form>
            <form action="admin.php" method="post">
                <button class="bt" name="add"> Add new car</button>
            </form>
            <form action="admin.php" method="post">
                <button class="up" name="update">Update car status</button>
            </form>

        </aside>

        <main>
            <!-- tables from queries gggg -->


            <?php          //start php!!!!

            function drawTable($row_new, $query_new)
            {
                $numColumns = mysqli_num_fields($query_new);

                echo '<table style="width: 96px;%">';
                echo '<tr>';
                for ($i = 0; $i < $numColumns; $i++) {
                    $fieldName = mysqli_fetch_field_direct($query_new, $i)->name;
                    if ($fieldName !== "car_id") {
                        echo "<th>$fieldName</th>";
                    }
                }
                echo '</tr>';

                do {
                    if ($row_new != null) {
                        echo '<tr>';
                        foreach ($row_new as $fieldName => $columnValue) {
                            if ($fieldName !== "car_id") {
                                if (str_contains($columnValue, "assets")) {
                                    $width = 130;
                                    $height = 100;
                                    echo "<td><img src='../{$row_new['image']}' alt='photo' width='{$width}' height='{$height}' >";
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

            function addCar()
            {   //add care function
                echo '
                <div class="add-car">
        <form action="admin.php" method="post" onsubmit="return check()">
            <h2>Add new car:</h2>
            <br>

            <label for="car_status">car status</label>
            <input id="in1" type="text" name="car_status">
            <label for="model">car model</label>
            <input id="in2" type="text" name="model" >

            <label for="year">car year</label>
            <input id="in3" class="i3" type="text" name="year">
            <label for="plate_id">plate ID</label>
            <input id="in4" class="i4" type="text" name="plate_id">

            <label for="price_per_day">Price per day</label>
            <input id="in5" class="i5" type="text" name="price_per_day">
            <label for="office_id">office ID</label>
            <input id="in6" class="i6" type="text" name="office_id">

            <label for="color">Car Color</label>
            <input id="in8" type="text" id="co" name="color">

            <label for="no_seats">Number of Seats</label>
            <input id="in9" type="text" id="seats" name="no_seats">
            
            <label for="img">Car Image Name</label>
            <input id="in7" type="text" id="img" name="file_name">
        
            <button class="add-car" type="submit" name="add_car">Add car</button>
        </form>

    </div>';     //add new car!!
            }

            function update()
            {
                echo '
                <form id ="update" action="admin.php" method="post" onsubmit="return check2()">
            
            <h1 class="up">Update car status:</h1>
            <div class"choose">
                
            <label class="up-label" for="car_status">Car Status:</label>
            <select name="car_status" id="car_status">
            <option value="Available">Available</option>
            <option value="out_of_service">Out of Service</option>
            <option value="rented">Rented</option>
            </select>
            </div>
            <label class="up-label" >Enter car id you want to update</label>
            <input id="inp" class="up-inp" type="text" name="car_id" placeholder="car ID">

            <button class="btn3" type="submit" name="update_car">update car</button>
            </form>
                ';
            }

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



                //start !!query one!!!
                if (!empty($_POST['date1']) && !empty($_POST['date2'])) {
                    $fromDate1 = $_POST['date1'];
                    $toDate2 = $_POST['date2'];

                    // echo '<h1>';
                    // echo 'Enter a valid period';
                    // echo '</h1>';

                    // echo 'Result of Service number 1: <br><br>';
                    $query = mysqli_query($con, "SELECT r.reservation_date,r.pickup_date,r.return_date,c.*,u.Fname,u.Lname,u.user_id,u.email,u.country FROM reservation 
                        AS r JOIN car AS c ON r.car_id =c.car_id JOIN user as u ON r.user_id = u.user_id WHERE (r.pickup_date BETWEEN '$fromDate1' AND '$toDate2')
                        or (r.return_date BETWEEN '$fromDate1' AND '$toDate2');
                        ");
                    if ($query) {
                        $row = mysqli_fetch_assoc($query);

                        drawTable($row, $query);
                        // header("Location: admin.php");
                        // exit();
                    } else {
                        echo '<br>';
                        echo "Failed to get The Table";
                    }
                }

                //end !!query one!!!


                //start !!query 2!!!
                else   if (!empty($_POST['date3']) && !empty($_POST['date4'])) {
                    $fromDate1 = $_POST['date3'];
                    $toDate2 = $_POST['date4'];
                    // echo 'Result of Service number 2: <br><br>';
                    $query = mysqli_query($con, "SELECT * FROM reservation AS r JOIN car AS c ON r.car_id =c.car_id
                        WHERE (r.pickup_date BETWEEN  '$fromDate1' AND '$toDate2') or( r.return_date BETWEEN '$fromDate1' AND '$toDate2');
                        ");
                    if ($query) {
                        $row = mysqli_fetch_assoc($query);

                        drawTable($row, $query);
                        // header("Location: admin.php");
                        // exit();
                    } else {
                        echo '<br>';
                        echo "Failed to get The Table";
                    }
                }

                //end !!query 2!!!


                //start !!query 3!!!
                else   if (!empty($_POST['date5'])) {
                    $fromDate1 = $_POST['date5'];

                    // echo 'Result of Service number 3: <br><br>';
                    $query = mysqli_query($con, "SELECT  car.car_id,car.plate_id, 'rented' AS car_status
                    FROM car 
                    INNER JOIN reservation ON car.car_id = reservation.car_id
                    WHERE '" . $fromDate1 . "' BETWEEN reservation.pickup_date AND reservation.return_date
                    UNION
                    SELECT car.car_id,car.plate_id, 'availble' AS car_status
                    FROM car
                    WHERE car.car_id NOT IN (
                        SELECT car.car_id
                        FROM car 
                        INNER JOIN reservation ON car.car_id = reservation.car_id
                        WHERE '" . $fromDate1 . "' BETWEEN reservation.pickup_date AND reservation.return_date
                    );");
                    if ($query) {
                        $row = mysqli_fetch_assoc($query);

                        drawTable($row, $query);
                    } else {
                        echo '<br>';
                        echo "Failed to get The Table";
                    }
                }

                //end !!query 3!!!



                //start !!query 4!!!
                else   if (!empty($_POST['cus_no'])) {
                    $customer_number = $_POST['cus_no'];
                    echo 'Result of Service number 4: <br><br>';
                    $query = mysqli_query($con, "SELECT u.*,r.reservation_id,r.reservation_date,c.model,c.plate_id from reservation
                    as r inner join car as c on c.car_id=r.car_id inner join user as u on u.user_id=r.user_id
                    WHERE u.user_id='$customer_number';");
                    if ($query) {
                        $row = mysqli_fetch_assoc($query);

                        drawTable($row, $query);
                    } else {
                        echo '<br>';
                        echo "Failed to get The Table";
                    }
                }
                //end !!query 4!!!


                //start !!query 5!!!
                else   if (
                    !empty($_POST['date6']) && !empty($_POST['date7'])
                ) { {
                        $fromDate1 = $_POST['date6'];
                        $toDate2 = $_POST['date7'];
                        // echo 'Result of Service number 5: <br><br>';
                        $query = mysqli_query($con, "SELECT p.*, r.user_id, r.car_id 
                    FROM payment AS p 
                    INNER JOIN reservation AS r ON r.reservation_id = p.reservation_id
                    WHERE p.payment_date BETWEEN '$fromDate1' AND '$toDate2';
");
                        if ($query) {
                            $row = mysqli_fetch_assoc($query);

                            drawTable($row, $query);
                        } else {
                            echo '<br>';
                            echo "Failed to get The Table";
                        }
                    }
                }
                //end !!query 5!!!
                else {
                    echo '<h1 style="margin-left: 80px;">invalid input</h1>';
                    echo '<h1 style="margin-left: 80px; font-weight 100px; font-size:20px">Enter a valid date or period</h1>';
                    // echo '<h2 style="margin-left: 80px;>Enter a valid date or period</h2>';
                    // echo '</h1>';
                }
            } else  if (isset($_POST['add'])) {
                addCar();
            }
            if (isset($_POST['add_car'])) {
                $car_status = $_POST['car_status'];
                $model = $_POST['model'];
                $year = $_POST['year'];
                $plate_id = $_POST['plate_id'];
                $price_per_day = $_POST['price_per_day'];
                $office_id = $_POST['office_id'];
                $fileName = $_POST['file_name'];
                $color = $_POST['color'];
                $no_seats = $_POST['no_seats'];

                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $sql = "INSERT INTO car (car_status, image, model,office_id,plate_id,price_per_day,`year`,color,numberOfSeats)
                    VALUES ('$car_status', '$fileName','$model','$office_id','$plate_id','$price_per_day','$year','$color','$no_seats')";

                if (mysqli_query($con, $sql)) {

                    echo
                    '<h2>Your car have been added successfully</h2>';
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "Failed to insert data: " . mysqli_error($con);
                }
            } else  if (isset($_POST['update'])) {
                update();
            }
            if (isset($_POST['update_car'])) {
                $id = $_POST['car_id'];
                $new_value = $_POST['car_status'];
                $sql = "UPDATE car SET car_status = '$new_value' WHERE car.car_id = '$id'";
                if (mysqli_query($con, $sql)) {

                    echo '<h2>Your car have been updated successfully</h2>';
                    header("Location: admin.php");
                    exit();
                } else {
                    echo "Failed to update car: " . mysqli_error($con);
                }
            }
            ?>
        </main>

    </div>

    <!-- <footer>
        <div class="box">
            <p>&copy; 2023 Car Retail</p>
            <h4>contact us</h4>
            <ul class="links">
                <li><a href=""><i><svg width="11" height="19" viewBox="0 0 11 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.31339 18.3945V10.1839H10.2081L10.6415 6.98403H7.31331V4.94106C7.31331 4.01463 7.58348 3.38332 8.97893 3.38332L10.7586 3.38252V0.520603C10.4508 0.481677 9.39429 0.394531 8.16531 0.394531C5.59929 0.394531 3.84255 1.88571 3.84255 4.62426V6.98403H0.94043V10.1839H3.84255V18.3945H7.31339V18.3945Z" fill="#4A3AFF" />
                            </svg>
                        </i> Facebook </a></li>
                <li><a href=""><i><svg width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.8767 0.0960151V0.0927734H13.7207L14.0291 0.154365C14.2346 0.194352 14.4213 0.246753 14.589 0.311587C14.7567 0.376421 14.9191 0.452065 15.0759 0.538505C15.2328 0.624944 15.3751 0.713021 15.5028 0.802702C15.6294 0.891313 15.743 0.985322 15.8437 1.08473C15.9432 1.18522 16.0985 1.21115 16.3095 1.16253C16.5205 1.1139 16.7477 1.04636 16.9912 0.959923C17.2346 0.873484 17.4754 0.776233 17.7135 0.668172C17.9515 0.56011 18.0965 0.4915 18.1485 0.462325C18.1993 0.43208 18.2264 0.415872 18.2296 0.4137L18.2328 0.408837L18.2491 0.400733L18.2653 0.392629L18.2815 0.384525L18.2978 0.376421L18.301 0.371558L18.3059 0.368316L18.3108 0.365075L18.314 0.360212L18.3302 0.35535L18.3465 0.352108L18.3432 0.376421L18.3383 0.400733L18.3302 0.425046L18.3221 0.449358L18.314 0.465567L18.3059 0.481775L18.2978 0.506088C18.2924 0.522296 18.287 0.543902 18.2815 0.570921C18.2761 0.597941 18.2247 0.705986 18.1273 0.89509C18.03 1.08419 17.9082 1.27599 17.7621 1.47049C17.6161 1.66499 17.4851 1.81193 17.3694 1.91136C17.2525 2.01185 17.1751 2.08208 17.1373 2.12207C17.0994 2.16312 17.0534 2.20094 16.9993 2.23552L16.9181 2.28901L16.9019 2.29712L16.8857 2.30522L16.8824 2.31008L16.8776 2.31333L16.8727 2.31657L16.8694 2.32143L16.8532 2.32953L16.837 2.33764L16.8338 2.3425L16.8289 2.34574L16.824 2.34898L16.8208 2.35385L16.8175 2.35871L16.8126 2.36195L16.8078 2.36519L16.8045 2.37005H16.8857L17.3401 2.2728C17.6431 2.20797 17.9326 2.12964 18.2085 2.03778L18.6467 1.89191L18.6954 1.8757L18.7198 1.86759L18.736 1.85949L18.7522 1.85139L18.7685 1.84328L18.7847 1.83518L18.8171 1.83031L18.8496 1.82707V1.85949L18.8415 1.86273L18.8334 1.86759L18.8301 1.87246L18.8253 1.8757L18.8204 1.87894L18.8171 1.8838L18.8139 1.88867L18.809 1.89191L18.8042 1.89515L18.8009 1.90001L18.7977 1.90487L18.7928 1.90812L18.7847 1.92432L18.7766 1.94053L18.7717 1.94377C18.7695 1.94702 18.7008 2.03885 18.5656 2.21932C18.4303 2.40085 18.3573 2.49269 18.3465 2.49486C18.3356 2.4981 18.3205 2.51431 18.301 2.54348C18.2826 2.57373 18.1679 2.69422 17.9569 2.90493C17.7459 3.11564 17.5393 3.30311 17.3369 3.46736C17.1335 3.63269 17.0307 3.83583 17.0285 4.0768C17.0253 4.31668 17.0128 4.58792 16.9912 4.89046C16.9695 5.19302 16.929 5.51988 16.8694 5.87107C16.8099 6.22226 16.718 6.61936 16.5935 7.06239C16.4691 7.50541 16.3176 7.93764 16.1391 8.35906C15.9605 8.78048 15.7739 9.15867 15.5791 9.49365C15.3843 9.82863 15.2058 10.1123 15.0435 10.3446C14.8812 10.5769 14.7162 10.7957 14.5484 11.001C14.3807 11.2063 14.1687 11.4376 13.9122 11.6948C13.6547 11.9508 13.514 12.0913 13.4902 12.1162C13.4653 12.1399 13.3593 12.2286 13.1721 12.382C12.986 12.5365 12.7858 12.691 12.5715 12.8455C12.3584 12.999 12.1625 13.127 11.984 13.2297C11.8054 13.3323 11.5901 13.4496 11.338 13.5814C11.087 13.7143 10.8153 13.8375 10.5232 13.951C10.231 14.0644 9.92265 14.1698 9.59803 14.267C9.27341 14.3643 8.95962 14.4399 8.65664 14.4939C8.35368 14.548 8.01012 14.5939 7.62598 14.6317L7.04979 14.6884V14.6965H5.99479V14.6884L5.85682 14.6803C5.76486 14.6749 5.68911 14.6695 5.62959 14.6641C5.57009 14.6587 5.34555 14.629 4.95601 14.575C4.56647 14.521 4.2608 14.4669 4.03897 14.4129C3.81716 14.3589 3.48712 14.2562 3.04889 14.1049C2.61066 13.9537 2.23572 13.8008 1.92409 13.6462C1.61355 13.4928 1.41878 13.3955 1.33978 13.3545C1.26187 13.3145 1.17423 13.2648 1.07684 13.2054L0.930764 13.1162L0.927534 13.1114L0.922648 13.1081L0.917779 13.1049L0.914533 13.1L0.898302 13.0919L0.882071 13.0838L0.878841 13.079L0.873956 13.0757L0.869086 13.0725L0.86584 13.0676L0.86261 13.0627L0.857725 13.0595H0.849609V13.0271L0.86584 13.0303L0.882071 13.0352L0.95511 13.0433C1.0038 13.0487 1.13636 13.0568 1.35277 13.0676C1.56919 13.0784 1.79911 13.0784 2.04258 13.0676C2.28604 13.0568 2.53492 13.0325 2.78919 12.9947C3.04348 12.9569 3.34375 12.892 3.69001 12.8002C4.03627 12.7083 4.3544 12.5992 4.6444 12.4728C4.9333 12.3453 5.13888 12.2502 5.26117 12.1875C5.38235 12.1259 5.56738 12.0114 5.81625 11.8439L6.18956 11.5926L6.1928 11.5878L6.19767 11.5845L6.20256 11.5813L6.20579 11.5764L6.20903 11.5716L6.2139 11.5683L6.21879 11.5651L6.22202 11.5602L6.23825 11.5554L6.25448 11.5521L6.25772 11.5359L6.26259 11.5197L6.26748 11.5165L6.27071 11.5116L6.14086 11.5035C6.0543 11.4981 5.97044 11.4927 5.88928 11.4873C5.80813 11.4819 5.68099 11.4576 5.50786 11.4143C5.33474 11.3711 5.14809 11.3063 4.9479 11.2198C4.74772 11.1334 4.55295 11.0307 4.36359 10.9119C4.17424 10.793 4.03735 10.6941 3.95295 10.6153C3.86963 10.5375 3.76142 10.4273 3.62833 10.2846C3.49632 10.1409 3.38162 9.9934 3.28424 9.84213C3.18685 9.69086 3.0938 9.51633 3.00508 9.3186L2.87035 9.02361L2.86223 8.99929L2.85412 8.97498L2.84925 8.95877L2.846 8.94256L2.87035 8.94581L2.8947 8.95067L3.07323 8.97498C3.19227 8.99119 3.37893 8.99659 3.6332 8.99119C3.88749 8.98579 4.06332 8.97498 4.1607 8.95877C4.25809 8.94256 4.3176 8.93175 4.33924 8.92636L4.3717 8.91825L4.41228 8.91015L4.45286 8.90204L4.4561 8.89718L4.46097 8.89394L4.46586 8.8907L4.46909 8.88583L4.43662 8.87773L4.40416 8.86963L4.3717 8.86152L4.33924 8.85342L4.30678 8.84531C4.28514 8.83992 4.24728 8.82911 4.19316 8.8129C4.13906 8.79669 3.99299 8.73725 3.75493 8.6346C3.51689 8.53196 3.32752 8.432 3.18685 8.33475C3.04583 8.23722 2.91137 8.13055 2.78433 8.01544C2.65772 7.89874 2.51869 7.74854 2.36719 7.56485C2.21571 7.38116 2.08046 7.16774 1.96142 6.92462C1.8424 6.68149 1.75313 6.44918 1.69361 6.22766C1.63433 6.00744 1.59522 5.7823 1.57677 5.55501L1.54754 5.21463L1.56377 5.21787L1.58 5.22273L1.59623 5.23084L1.61246 5.23894L1.62869 5.24705L1.64492 5.25515L1.8965 5.36861C2.06423 5.44426 2.27252 5.50909 2.52139 5.56311C2.77027 5.61713 2.91904 5.64686 2.96773 5.65226L3.04077 5.66036H3.18685L3.18362 5.6555L3.17873 5.65226L3.17387 5.64902L3.17062 5.64415L3.16739 5.63929L3.1625 5.63605L3.15763 5.63281L3.15439 5.62794L3.13816 5.61984L3.12193 5.61174L3.1187 5.60687L3.11381 5.60363L3.10894 5.60039L3.1057 5.59553L3.08947 5.58742L3.07323 5.57932L3.07 5.57446C3.06676 5.57229 3.02022 5.53771 2.9304 5.47072C2.84167 5.40265 2.74862 5.31459 2.65123 5.20653C2.55385 5.09846 2.45646 4.98501 2.35908 4.86615C2.26151 4.74702 2.17461 4.61957 2.09938 4.48525C2.02365 4.35019 1.94357 4.17836 1.85917 3.96982C1.77585 3.76236 1.71255 3.55327 1.66927 3.34256C1.626 3.13185 1.60165 2.92385 1.59623 2.71854C1.59082 2.51322 1.59623 2.33764 1.61246 2.19176C1.62869 2.04589 1.66115 1.8811 1.70984 1.69741C1.75854 1.51372 1.82888 1.31922 1.92084 1.1139L2.05881 0.805943L2.06692 0.781631L2.07504 0.757318L2.07992 0.754076L2.08315 0.749214L2.0864 0.744351L2.09127 0.74111L2.09615 0.744351L2.09938 0.749214L2.10263 0.754076L2.1075 0.757318L2.11238 0.76056L2.11561 0.765422L2.11886 0.770285L2.12373 0.773527L2.13185 0.789735L2.13996 0.805943L2.14485 0.809185L2.14808 0.814048L2.36719 1.05717C2.51327 1.21926 2.6864 1.40026 2.88658 1.60016C3.08677 1.80005 3.19768 1.90379 3.21931 1.91136C3.24096 1.92 3.268 1.94484 3.30047 1.98592C3.33293 2.0259 3.44114 2.12153 3.62508 2.2728C3.80904 2.42408 4.0498 2.59968 4.34736 2.79958C4.64493 2.99948 4.97495 3.19668 5.33744 3.39118C5.69994 3.58569 6.08948 3.76127 6.50606 3.91796C6.92265 4.07464 7.21481 4.17729 7.38252 4.22592C7.55025 4.27454 7.83699 4.33667 8.24276 4.41231C8.64853 4.48796 8.95422 4.53658 9.1598 4.55819C9.36539 4.5798 9.50607 4.59223 9.5818 4.59547L9.69542 4.59871L9.69219 4.5744L9.6873 4.55009L9.65484 4.34748C9.6332 4.21242 9.62238 4.02331 9.62238 3.78019C9.62238 3.53706 9.64132 3.31285 9.67919 3.10754C9.71707 2.90223 9.77388 2.69422 9.84961 2.48351C9.92536 2.2728 9.99949 2.10369 10.072 1.97619C10.1456 1.84976 10.2419 1.70551 10.3609 1.54343C10.4799 1.38134 10.6341 1.21386 10.8235 1.04097C11.0128 0.86807 11.2292 0.71409 11.4727 0.579026C11.7162 0.443961 11.9407 0.341297 12.1463 0.271066C12.3519 0.200835 12.525 0.1549 12.6657 0.133294C12.8063 0.111689 12.8767 0.0992568 12.8767 0.0960151V0.0960151Z" fill="#4A3AFF" />
                            </svg>
                        </i> Twitter</a></li>
                <li><a href=""><i><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.849609 9.39453C0.849609 5.79939 0.849609 4.00182 1.7063 2.70708C2.08886 2.12892 2.584 1.63378 3.16216 1.25122C4.4569 0.394531 6.25447 0.394531 9.84961 0.394531C13.4447 0.394531 15.2423 0.394531 16.5371 1.25122C17.1152 1.63378 17.6104 2.12892 17.9929 2.70708C18.8496 4.00182 18.8496 5.79939 18.8496 9.39453C18.8496 12.9897 18.8496 14.7872 17.9929 16.082C17.6104 16.6601 17.1152 17.1553 16.5371 17.5378C15.2423 18.3945 13.4447 18.3945 9.84961 18.3945C6.25447 18.3945 4.4569 18.3945 3.16216 17.5378C2.584 17.1553 2.08886 16.6601 1.7063 16.082C0.849609 14.7872 0.849609 12.9897 0.849609 9.39453ZM14.5089 9.39476C14.5089 11.9681 12.4228 14.0542 9.84945 14.0542C7.27613 14.0542 5.19004 11.9681 5.19004 9.39476C5.19004 6.82144 7.27613 4.73535 9.84945 4.73535C12.4228 4.73535 14.5089 6.82144 14.5089 9.39476ZM9.84945 12.4778C11.5521 12.4778 12.9325 11.0975 12.9325 9.39476C12.9325 7.69206 11.5521 6.31176 9.84945 6.31176C8.14675 6.31176 6.76645 7.69206 6.76645 9.39476C6.76645 11.0975 8.14675 12.4778 9.84945 12.4778ZM14.6929 5.59608C15.2975 5.59608 15.7877 5.10591 15.7877 4.50126C15.7877 3.8966 15.2975 3.40643 14.6929 3.40643C14.0882 3.40643 13.5981 3.8966 13.5981 4.50126C13.5981 5.10591 14.0882 5.59608 14.6929 5.59608Z" fill="#4A3AFF" />
                            </svg>
                        </i> Instagram</a></li>
            </ul>
        </div>
    </footer> -->




    <script>
        function search() {
            window.location.href = "search.html";

            document.getElementById("submit").submit();
        }


        function logout() {
            console.log("Logout function called");
            window.location.href = "../logout.php";
        }

        function check() {
            var x1 = document.getElementById('in1').value;
            var x2 = document.getElementById('in2').value;
            var x3 = document.getElementById('in3').value;
            var x4 = document.getElementById('in4').value;
            var x5 = document.getElementById('in5').value;
            var x6 = document.getElementById('in6').value;
            var x7 = document.getElementById('in7').value;
            var x8 = document.getElementById('in8').value;
            var x9 = document.getElementById('in9').value;


            if (!x1) {
                alert("Enter a year to search")
                return false;
            }
            if (!x2) {
                alert("Enter a model to search")
                return false;
            }
            if (!x3) {
                alert("Enter a start price")
                return false;
            }
            if (!x4) {
                alert("Enter end price")
                return false;
            }
            if (!x5) {
                alert("Enter a country")
                return false;
            }
            if (!x6) {
                alert("Enter a state")
                return false;
            }
            if (!x7) {
                alert("Enter image name");
                return false;
            }
            if(!x8){
                alert("Enter a color");
                return false;
            }
            if(!x9){
                alert("Enter number of seats");
                return false;
            }
            return true;
        }

        function check2() {
            var x = document.getElementById('inp').value;
            if (!x) {
                alert("Enter car ID");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>