<?php
include_once("../database/constants.php");
include_once("User.php");
include_once("Costumer.php");
include_once("Admin.php");

// login user account handler
if (isset($_POST["username"], $_POST["password"], $_POST["user_type"])){
    $user = new User();
    $result = $user->userLogin($_POST["username"], $_POST["password"], $_POST["user_type"]);
    echo $result;
    exit;
}

// Logout Function
if (isset($_GET["logout"])){
    $user = new User();
    $user->logout();
}


/*********************************************************
 *      _____          _
 *    / ____|        | |
 *   | |     ___  ___| |_ _   _ _ __ ___   ___ _ __
 *  | |    / _ \/ __| __| | | | '_ ` _ \ / _ \ '__|
 * | |___| (_) \__ \ |_| |_| | | | | | |  __/ |
 * \_____\___/|___/\__|\__,_|_| |_| |_|\___|_|
 *
 * ********************************************************/

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
if (isset($_POST["itemID"],$_POST["getStock"])){
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
// Get all order with pagination
if (isset($_POST["getData"], $_POST["clientID"])){

    if (isset($_POST["page"])){
        $page = $_POST["page"];
    } else {
        $page = 1;
    }

    $costumer = new Costumer();
    $result = $costumer->getAllData($page, $_POST["clientID"]);
    echo $result;
    exit;
}

/**********************************************************************
*               _           _             __   _____  _____ _____
*     /\      | |         (_)           / /  / ____|/ ____|  __ \
*    /  \   __| |_ __ ___  _ _ __      / /  | |    | (___ | |__) |
*   / /\ \ / _` | '_ ` _ \| | '_ \    / /   | |     \___ \|  _  /
*  / ____ \ (_| | | | | | | | | | |  / /    | |____ ____) | | \ \
* /_/    \_\__,_|_| |_| |_|_|_| |_| /_/      \_____|_____/|_|  \_\
**********************************************************************/

// Inventory filter function
if (isset($_POST["selectedUserIDs"])){
    $inventory = new Admin();
    $result = $inventory->getUserItem($_POST["selectedUserIDs"]);
    echo $result;
    exit;
}
// Order Filter function
if (isset($_POST["selectedUsers"], $_POST["dateFrom"], $_POST["dateTo"])){
    $order = new Admin();
    $result = $order->getUserOrder($_POST["selectedUsers"], $_POST["dateFrom"], $_POST["dateTo"]);
    echo $result;
    exit;
}
// Edit Client Info
if (isset($_POST["clientID"], $_POST["name"], $_POST["address"], $_POST["zipCode"])){
    $order = new Admin();
    $result = $order->editClientInfo($_POST["clientID"], $_POST["name"], $_POST["address"], $_POST["zipCode"]);
    echo $result;
    exit;
}
// Get Client Info
if (isset($_POST["clientID"], $_POST["getClientInfo"])){
    $order = new Admin();
    $result = $order->getClientInfo($_POST["clientID"]);
    echo $result;
    exit;
}
// Delete Order function
if (isset($_POST["orderID"], $_POST["userLoggedInID"], $_POST["adminID"], $_POST["itemID"], $_POST["itemQty"])){

    $order = new Admin();
    $result = $order->deleteOrder($_POST["orderID"], $_POST["userLoggedInID"], $_POST["adminID"], $_POST["itemID"], $_POST["itemQty"]);
    echo $result;
    exit;
}

// Function uses to get all order with pagination
if (isset($_POST["getOrderData"], $_POST["adminID"], $_POST["userType"])){

    if (isset($_POST["page"])){
        $page = $_POST["page"];
    } else {
        $page = 1;
    }

    $costumer = new Admin();
    $result = $costumer->getAllOrder($page, $_POST["adminID"], $_POST["userType"]);
    echo $result;
    exit;
}
// Cancel order
if (isset($_POST["cancelOrder"])){
    $order = new Admin();
    $result = $order->cancelOrder($_POST["orderID"], $_POST["userLoggedInID"], $_POST["adminID"], $_POST["itemID"], $_POST["itemQty"]);
    echo $result;
    exit;
}
?>