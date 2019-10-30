<?php
include_once("../database/constants.php");
include_once("user.php");
// include_once("DBOperation.php");

// login user account handler
if (isset($_POST["username"], $_POST["password"], $_POST["user_type"])){
    $user = new User();
    $result = $user->userLogin($_POST["username"], $_POST["password"], $_POST["user_type"]);
    echo $result;
    exit;
}

?>