<?php 


class user {

public $id;
public $Fname;
public $Lname;
public $email;
public $country;
public $state;
protected $password;

public function __construct($id, $Fname, $Lname,$email, $password, $country, $state) {
    $this->id = $id;
    $this->Fname = $Fname;
    $this->Lname = $Lname;    
    $this->email = $email;
    $this->password = $password;
    $this->country = $country;
    $this->state = $state;

}

static function login($email, $password){
    $user = null;
    require_once("config.php");

    $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);

    $sql = "SELECT * FROM user WHERE `email` = '$email' AND `password` = '$password'";

    $rslt = mysqli_query($connect, $sql);

    if ($result = mysqli_fetch_assoc($rslt))
    {
        $user = new user($result["user_id"], $result["Fname"], $result["Lname"],$result["email"], $result["password"], $result["country"], $result["state"]);
        
    }
    mysqli_close($connect);
    return $user;
}

static function signup($Fname, $Lname, $email, $password, $country, $state){
    require_once("config.php");

    $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);


    $sql = "INSERT INTO user (Fname, Lname, email, password, country, state) values('$Fname', '$Lname', '$email', '$password', '$country', '$state')";

    try {
        $rslt = mysqli_query($connect, $sql);
        mysqli_close($connect);
        header("location:index.php?msg=done");
    } catch (\Throwable $th) {
        mysqli_close($connect);
        header("location:signup.php?msg=error");
    }
}

static function showCars()
{
    require_once('config.php');
    $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);
    $qry = "SELECT year ,model ,price_per_day ,image ,car_id FROM car Where car_status='Available' ORDER BY RAND() LIMIT 6";
    $result = mysqli_query($connect, $qry);
    $data = mysqli_fetch_all($result);
    mysqli_close($connect);
    return $data;
}


function showCarDetails ($car_id)
{
    require_once('config.php');
    $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);
    $qry = "SELECT * FROM car WHERE car_id = $car_id";
    $result = mysqli_query($connect, $qry);
    $data = mysqli_fetch_assoc($result); // Fetch as an associative array
    mysqli_close($connect);

    return $data;

}



}


class admin {

    public $id;
    public $fname;
    public $lname;
    public $email;
    protected $password;
    
    public function __construct($id, $fname, $lname,$email, $password) {
        $this->id = $id;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->password = $password;
    
    }
    
    static function login($email, $password){
        $admin = null;
        require_once("config.php");
    
        $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);
    
        $sql = "SELECT * FROM admin WHERE `email` = '$email' AND `password` = '$password'";
    
        $rslt = mysqli_query($connect, $sql);
    
        if ($result = mysqli_fetch_assoc($rslt))
        {
            $admin = new admin($result["admin_id"], $result["fname"], $result["lname"], $result["email"], $result["password"]);
            
        }
        mysqli_close($connect);
        return $admin;
    }
    
    static function signup($fname, $lname, $email, $password){
        require_once("config.php");
    
        $connect = new mysqli(DB_host, DB_user_name, DB_user_password, DB_name);
    
    
        $sql = "INSERT INTO admin (Fname, Lname, email , password) values('$fname', '$lname', '$email', '$password')";
    
        try {
            $rslt = mysqli_query($connect, $sql);
            mysqli_close($connect);
            header("location:index.php?msg=done");
        } catch (\Throwable $th) {
            mysqli_close($connect);
            header("location:signup.php?msg=error");
        }
    }
    
    }
    
