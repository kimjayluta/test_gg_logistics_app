<?php
include_once("../database/constants.php");
include_once("user.php");
// include_once("DBOperation.php");

// login user account handler
if (isset($_POST["username"], $_POST["password"])){
    $user = new User();
    $result = $user->userLogin($_POST["username"], $_POST["password"]);
    echo $result;
    exit;
}

?>