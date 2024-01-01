<?php
session_start();
if (empty($_SESSION["user"])) {
    header("location:unauthorized.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/search_all.css">
    <link rel="shortcut icon" href="assets/seo.png" type="image/x-icon">
    <title>Search</title>
</head>

<body>
    <!-- <img class="logo" src="assets/h.png" alt="logo"> -->
    <div class="header">
        <h1>Find a car</h1>
        <img class="im" src="assets/q.png" alt="car">
    </div>

    <div id="s1" class="search1">
        <form id="d3" class="form1" action="backend/finalsearch.php" method="post" onsubmit="return check1()">
            <div class="input-container">
                <span class="additional">car spec</span>
                <input id="ss1" name="text" class="input1" type="text" placeholder="What are you looking for?">
            </div>
            <button class="bt" name="search1">Find your car</button>
        </form>
        <div class="switch">
            <button onclick="switchPage()">Want to find a specific car?</button>
        </div>
    </div>

    <div id="s2" class="search2">
        <form class="form2" action="backend/finalsearch.php" method="post" onsubmit="return check2()">
            <input id="in1" type="number" name="year" placeholder="Year">
            <input id="in2" type="text" name="model" placeholder="Model">

            <label for="price-from">Range of prices from:</label>
            <input id="in3" type="number" id="price-from" name="price-from">

            <label for="price-to"> To</label>
            <input id="in4" type="number" id="price-to" name="price-to">

            <label for="country">Country</label>
            <input id="in5" type="text" id="country" name="country" placeholder="Country">

            <label for="state">State</label>
            <input id="in6" type="text" id="state" name="state" placeholder="State">

            <button class="bt" name="search2">Find your car</button>
        </form>
        <div class="bt22">
            <div class="switch">
                <button onclick="switchPage()">Search by one spec again?</button>
            </div>
        </div>
    </div>

    <script>
        function switchPage() {
            var s1 = document.getElementById("s1");
            var s2 = document.getElementById("s2");

            if (s1.style.display === "flex") {
                console.log("Switching pages...");
                s1.style.display = "none";
                s2.style.display = "flex";
            } else {
                console.log("Switching pages...");
                s2.style.display = "none";
                s1.style.display = "flex";
            }
        }

        function check1() {
            var x = document.getElementById('ss1').value;
            if (!x) {
                alert('Enter a value to search')

                return false;
            }
            return true;
        }

        function check2() {
            var x1 = document.getElementById('in1').value;
            var x2 = document.getElementById('in2').value;
            var x3 = document.getElementById('in3').value;
            var x4 = document.getElementById('in4').value;
            var x5 = document.getElementById('in5').value;
            var x6 = document.getElementById('in6').value;

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
            return true;
        }
    </script>
</body>

</html>