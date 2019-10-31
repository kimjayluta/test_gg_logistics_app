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

// Get the available stock
if (isset($_POST["itemID"])){
    $costumer = new Costumer();
    $result = $costumer->getAvailableStock($_POST["itemID"]);
    echo $result;
    exit;
}
// Create a new Order
if (isset($_POST["item"], $_POST["qty"], $_POST["costumerID"], $_POST["userID"])){
    $costumer = new Costumer();
    $result = $costumer->createOrder($_POST["item"], $_POST["costumerID"], $_POST["userID"], $_POST["qty"]);
    echo $result;
    exit;
}
?>