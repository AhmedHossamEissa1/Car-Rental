<?php
session_start();
require_once("class.php");
// var_dump($_POST);
// var_dump($_POST["userType"]);
if ($_POST["userType"] == "user") {

   if (!empty($_POST["email"]) && !empty($_POST["password"])) {
      $email = htmlspecialchars(trim($_POST["email"]));
      $password = md5(trim($_POST["password"]));

      $user = user::login($email, $password);

      if ($user == NULL) {
         header("location:login.php?msg=w_e_p");
      } else {
         $_SESSION["user"] = serialize($user);
         header("location:index.html");
      }
   }
} else {
   if (!empty($_POST["email"]) && !empty($_POST["password"])) {
      $email = htmlspecialchars(trim($_POST["email"]));
      $password = md5(trim($_POST["password"]));

      $admin = admin::login($email, $password);

      if ($admin == NULL) {
         header("location:login.php?msg=w_e_p");
      } else {
         $_SESSION["user"] = serialize($user);
         header("location:backend/admin.php");
      }
   }
}
