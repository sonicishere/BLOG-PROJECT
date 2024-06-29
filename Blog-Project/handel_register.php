<?php
// var_dump($_REQUEST);
session_start();

$errors = [];

if (empty($_REQUEST["name"])) $errors["name"] = "Name Is Required";
if (empty($_REQUEST["email"])) $errors["email"] = "Email Is Required";
if (empty($_REQUEST["phone"])) {
    $_SESSION["errors"]["phone"] = "Phone number is required.";
} elseif (strlen($_REQUEST["phone"]) < 11) {
    $_SESSION["errors"]["phone"] = "Phone number must be at least 11 digits long.";
} else {
}

if (empty($_REQUEST["pw"]) || empty($_REQUEST["pc"])) 
{$errors["pw"] = "Password & Password Confirmation Is Required";
}else if ($_REQUEST["pw"] != $_REQUEST["pc"]) {
    $errors["pw"] = " Password Confirmation Must be equal to Password";
}


$name = htmlspecialchars(trim($_REQUEST["name"]));
$email = filter_var($_REQUEST["email"],FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_REQUEST["pw"]);
$password_confirmation = htmlspecialchars($_REQUEST["pc"]);
$phone = htmlspecialchars($_REQUEST["phone"]);


if ( !empty($_REQUEST["email"]) && !filter_var($_REQUEST["email"],FILTER_VALIDATE_EMAIL)) $errors["email"] = "Email Invalid Format Please Add aa@pp.com";

if (empty($errors)) {

    require_once('classes.php');
    try {
        $rslt = Subscriber::register($name,$email,md5($password),$phone);
        header("location:index.php?msg=sr");
    } catch (\Throwable $th) {
        // header("location:register.php?msg=ar");
        echo($th);
    }
    
    
}else{
    $_SESSION["errors"] = $errors;
    header("location:register.php");
}
