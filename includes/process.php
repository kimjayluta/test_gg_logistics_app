<?php
include_once("../database/constants.php");
include_once("user.php");
include_once("Costumer.php");

// login user account handler
if (isset($_POST["username"], $_POST["password"], $_POST["user_type"])){
    $user = new User();
    $result = $user->userLogin($_POST["username"], $_POST["password"], $_POST["user_type"]);
    echo $result;
    exit;
}

// Costumers Get Item list
if (isset($_POST["getItems"])){
    $costumer = new Costumer();
    $results = $costumer->getItemList();
    foreach($results as $result){
        echo "<option value='".$result["id"]."'>".$result["title"]."</option>";
    }
    exit;
}

?>