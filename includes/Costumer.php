<?php
class Costumer {
    private $_CON;

    function __construct(){
        include_once("../database/db.php");
        $db = new Database();
        $this->_CON = $db->connect();

        if ($this->_CON){
            return $this->_CON;
        }
    }

    public function getItemList(){
        $sql = "SELECT * FROM `items`";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $row = array();
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            return $rows;
        }
        return "ERROR";
    }

    public function getAvailableStock($itemID){
        $sql = "SELECT `qty_stock`,`reserved_stock` FROM `items` WHERE `id` = ?";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("i",$itemID);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row["qty_stock"] - $row["reserved_stock"];
        }
    }

    public function updateTheStock($itemID, $reservedQty){
        $sql = "SELECT `reserved_stock` FROM `items` WHERE `id` = ?";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("i",$itemID);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();

        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $reservedQtyInDatabase = $row["reserved_stock"];
            $updateQty = $reservedQty + $reservedQtyInDatabase;

            $sql = "UPDATE `items` SET `reserved_stock`= ? WHERE `id` = ?";
            $pre_stmt = $this->_CON->prepare($sql);
            $pre_stmt->bind_param("ii",$updateQty,$itemID);
            $result = $pre_stmt->execute() or die($this->_CON->error);
            if ($result) return 1;
        }
    }

    public function createOrder($itemID, $costumerID, $userID, $qty){
        $deliveryDate = date("Y-m-d H:i:s");
        $sql = "INSERT INTO `orders`(`item_id`, `client_id`, `user_id`, `delivery_date`, `item_qty`) VALUES (?,?,?,NOW(),?)";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param('iiii', $itemID,$costumerID,$userID,$qty);
        $result = $pre_stmt->execute() or die($this->_CON->error);

        if ($result){
            $this->updateTheStock($itemID, $qty);
            return 1;
        }
        return 0;
    }
}
?>