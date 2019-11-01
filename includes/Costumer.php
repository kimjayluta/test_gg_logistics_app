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

    // Get all the Item in the database
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

    // Get available stock function availableStock = overall_stock - reserved_stock
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

    // Function that updates the stock
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

    // Function for Creating a order and updating the reserved stock
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

    // Get all Order data with pagination
    public function getAllData($page, $clientID){
        $pages = "";
        $data = "";

        $record_per_page = 3;
        $start_from = ($page - 1)*$record_per_page;
        $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                WHERE b.id = a.item_id AND c.id = a.client_id
                AND a.client_id = ? ORDER BY a.delivery_date DESC LIMIT ?, ?";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("iii", $clientID, $start_from, $record_per_page);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();

        if ($result->num_rows > 0){
            while($row = $result->fetch_array()){
                $data .=
                '
                    <div class="card cd">
                        <div class="card-body cd">
                            <div class="row">
                                <div class="col-md-2 text-right" style="font-weight: bold;">
                                    <h6>Order ID: </h6>
                                    <hr>
                                    <h6>Name: </h6>
                                    <hr>
                                    <h6>Address: </h6>
                                    <hr>
                                    <h6>Zip Code: </h6>
                                    <hr>
                                    <h6>Ordered Date: </h6>
                                    <hr>
                                    <h6>Product: </h6>
                                    <hr>
                                    <h6>Quantity: </h6>
                                </div>
                                <div class="col-md-10"  style="font-style: italic;">
                                    <h6>'.$row["0"].'</h6>
                                    <hr>
                                    <h6>'.$row["name"].'</h6>
                                    <hr>
                                    <h6>'.$row["address"].'</h6>
                                    <hr>
                                    <h6>'.$row["postal_code"].'</h6>
                                    <hr>
                                    <h6>'.$row["delivery_date"].'</h6>
                                    <hr>
                                    <h6>'.$row["title"].'</h6>
                                    <hr>
                                    <h6>'.$row["item_qty"].'</h6>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

            // Display the Pagination
            $data .= "<div class='mt-4' style='float:right;'>";
            $sql = "SELECT * FROM `orders` WHERE `client_id` = ?";
            $pre_stmt = $this->_CON->prepare($sql);
            $pre_stmt->bind_param("i", $clientID);
            $pre_stmt->execute() or die($this->_CON->error);
            $result = $pre_stmt->get_result();
            $totalRecords = $result->num_rows;
            $totalPage = ceil($totalRecords/$record_per_page);

            $data .= '<nav aria-label="Page navigation example"><ul class="pagination">';
            for ($i = 1; $i <= $totalPage; $i++){
                if ($i == 1){
                    $data .= '<li class="page-item active"><span class="page-link pagination_link" id="'.$i.'">'.$i.'</span></li>';
                } else {
                    $data .= '<li class="page-item"><span class="page-link pagination_link" id="'.$i.'">'.$i.'</span></li>';
                }
            }
            $data .='</ul></nav></div>';
            echo $data;
        }


    }
}
?>