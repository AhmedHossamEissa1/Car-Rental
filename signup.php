<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/signup.png" type="image/x-icon">
    <title>SignUp</title>
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <div class="container">
        <header>
            <img src="assets/vendor-8.png" alt="Car Logo">
        </header>
        <form action="handelsignup.php" method="post" onsubmit="return validateForm() && check() && checkPasswords()">

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["msg"])) {
                $message = $_GET["msg"];

                if ($message == "error") {
                    echo '<div class="alert alertError" role="alert"><strong><b style="color: yellow;">Email Is Already Exist</b></strong></div>';
                }
            }
            ?>



            <div class="form-group">

                <label for="fname"><b>First Name:</b></label>
                <input type="text" name="fname" id="fN" placeholder="Enter your First Name">

                <label for="lname"><b>Last Name:</b></label>
                <input type="text" name="lname" id="lN" placeholder="Enter your Last Name">


                <label for="email"><b>Email:</b></label>
                <input type="text" name="email" id="E" placeholder="Enter your email">


                <label for="password"><b>Password:</b></label>
                <input type="password" name="password" id="P" placeholder="Enter your password">


                <label for="password"><b>Confirm Password:</b></label>
                <input type="password" name="password" id="CP" placeholder="Enter your password">

                <label for="country"><b>Country:</b></label>
                <input type="text" name="country" id="country" placeholder="Enter your Country">

                <label for="state"><b>State:</b></label>
                <input type="text" name="state" id="state" placeholder="Enter your State">

                <label for=""><b>Are you already have an account?</b></label>
                <a href="index.php" style="color: blue;"><b>Login</b></a>
                <button type="submit" style="font-size: medium; margin-top: 20px;"><b>Sign Up</b></button>
            </div>
        </form>
        <footer>
            <p><b>&copy;2023 Car Rental</b></p>
        </footer>
    </div>
</body>
<script>
    function validateEmail(email) {
        var emailPattern = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
        return emailPattern.test(email);
    }

    function validateForm() {
        var emailInput = document.getElementById("E");
        var email = emailInput.value;
        if (email === "") {
            return true;
        }
        if (!validateEmail(email)) {
            alert("Invalid email address. Please enter a valid email.");
            return false;
        }

        return true;
    }



    function check() {
        let id_fname = document.getElementById("fN").value;
        let id_lname = document.getElementById("lN").value;
        let id_email = document.getElementById("E").value;
        let id_password = document.getElementById("P").value;
        let id_Cpassword = document.getElementById("CP").value;
        let id_country = document.getElementById("country").value;
        let id_state = document.getElementById("state").value;

        if (id_fname === "") {
            alert("Empty Field. Please, Enter Your First Name");
            return false;

        }
        if (id_lname === "") {
            alert("Empty Field. Please, Enter Your Last Name");
            return false;

        }
        if (id_email === "") {
            alert("Empty Field. Please, Enter Your Email");
            return false;
        }
        if (id_password === "") {
            alert("Empty Field. Please, Enter Your Password");
            return false;
        }
        if (id_Cpassword === "") {
            alert("Empty Field. Please, Enter Your Password Again to confirm it");
            return false;
        }
        if (id_country === "") {
            alert("Empty Field. Please, Enter Your Country");
            return false;
        }
        if (id_state === "") {
            alert("Empty Field. Please, Enter Your State");
            return false;
        }

        return true;
    }

    function checkPasswords() {
        var password = document.getElementById("P").value;
        var confirmPassword = document.getElementById("CP").value;

        if (password === confirmPassword) {
            alert("Passwords Match");
            return true;
        } else {
            alert("Passwords do not Match!!");
            return false;
        }
        return true;
    }
</script>


</html>