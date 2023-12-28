<?php

require_once("class.php");

if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["country"] && !empty($_POST["state"])))
{
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = md5(trim($_POST["password"]));
    $country = htmlspecialchars(trim($_POST["country"]));
    $state = htmlspecialchars(trim($_POST["state"]));

    user::signup($fname, $lname, $email, $password, $country, $state);
}