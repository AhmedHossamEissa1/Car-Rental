<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="assets/user.png" type="image/x-icon">
  <title>Log In</title>
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <div class="container">
    <header>
      <img src="assets/vendor-8.png" alt="Car Logo">
    </header>
    <form action="handellogin.php" method="post" onsubmit="return validateForm() && check()">

      <div class="form-group">
        <?php
        if (!empty($_GET["msg"]) && $_GET["msg"] == "done") {
        ?>
          <div class="alert" role="alert">
            <strong><b style="color: greenyellow; font-weight:bold">Successfully SignUp</b></strong>
          </div>

        <?php
        }
        ?>

        <?php
        if (!empty($_GET["msg"]) && $_GET["msg"] == "w_e_p") {
        ?>
          <div class="alert" role="alert" style="font-weight:bold; color:#DDDBDB">
            <strong><b style="color: red; font-weight:bold">Wrong Email Or Password</b></strong> Login Again
          </div>

        <?php
        }
        ?>
        <label for="email"><b>Email:</b></label>
        <input type="text" name="email" id="E" placeholder="Enter your email">

        <label for="password"><b>Password:</b></label>
        <input type="password" name="password" id="P" placeholder="Enter your password">

        <!-- Circular radio buttons for user/admin choice -->
        <div class="circular-radio">
          <input type="radio" name="userType" id="user" value="user" checked>
          <label for="user">User</label>

          <input type="radio" name="userType" id="admin" value="admin">
          <label for="admin">Admin</label>
        </div>


        <label for=""><b>Don't have an account yet?</b></label>
        <a href="signup.php" style="color: blue;"><b>SignUp</b></a>
        <button type="submit" style="font-size: medium; margin-top: 20px;"><b>Log In</b></button>
      </div>
    </form>
    <footer>
      <p><b>&copy;2023 Car Rental</b></p>
    </footer>
  </div>
</body>
<script>
  function check() {
    let id_email = document.getElementById("E").value
    let id_password = document.getElementById("P").value
    if (id_email === "") {
      alert("Empty Field. Please,Enter Your Email")
      return false
    }
    if (id_password === "") {
      alert("Empty Field. Please, Enter Your Password")
      return false
    }

  }

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
</script>


</html>