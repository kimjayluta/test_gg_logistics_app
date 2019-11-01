<?php
class Admin {
    private $_CON;

    function __construct(){
        include_once("../database/db.php");
        $db = new Database();
        $this->_CON = $db->connect();

        if ($this->_CON){
            return $this->_CON;
        }
    }

    // This function uses to Get the User item when filtering
    public function getUserItem($userIDs = array()){
        $newUserIDs = implode(", ",$userIDs);

        $sql = "SELECT a.*,b.*,c.name FROM orders a, items b, clients c
                WHERE b.id = a.item_id AND c.id = a.client_id
                AND a.client_id IN ($newUserIDs)";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $rows = array();
        $table = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $availableStock = $row["qty_stock"] - $row["reserved_stock"];
                $table .= '
                            <tr>
                                <td>'.$row["item_id"].'</td>
                                <td>'.$row["title"].'</td>
                                <td>'.$availableStock.'</td>
                                <td>'.$row["reserved_stock"].'</td>
                                <td>'.$row["qty_stock"].'</td>
                                <td>'.$row["name"].'</td>
                            </tr>
                        ';
            }
            return $table;
        }
        return "NO_DATA_AVAILABLE";
    }

    public function insertLogged($orderID, $userLoggedInID, $adminID, $action){
        $sql = "INSERT INTO `history`(`user_id`, `admin_id`, `order_id`, `user_action`, `date_action`)
                    VALUES (?,?,?,?,NOW())";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("iiis", $userLoggedInID, $adminID, $orderID, $action);
        $result = $pre_stmt->execute() or die($this->_CON->error);
        return ($result) ? 1 : 0;
    }

    public function updateTheStock($itemID, $itemQty){
        $sql = "UPDATE `items` SET `reserved_stock` = `reserved_stock` - ? WHERE `id` = ?";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("ii", $itemQty, $itemID);
        $result = $pre_stmt->execute() or die($this->_CON->error);
        return ($result) ? 1 : 0;

    }

    // Filter and print function
    public function getUserOrder($userIDs, $dateFrom, $dateTo, $userType) {
        $newUserIDs = implode(",",$userIDs);

        $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                WHERE a.delivery_date BETWEEN '$dateFrom' AND '$dateTo'
                AND b.id = a.item_id
                AND c.id = a.client_id
                AND a.client_id IN ($newUserIDs)
                ORDER BY a.delivery_date DESC";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $data = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_array()){

                $data .=
                '<div class="card cd">
                        <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                            <div class="row" style="float:right">
                                <a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal"
                                data-id="'.$row['id'].'">
                                    <i class="fas fa-edit fa-lg mr-1"></i>
                                </a>';
                if ($userType == "admin"){
                    $data.= '<a href="#" class="delete-btn" data-id="'.$row['0'].'" data-adminid="'.$row["user_id"].'">
                                <i class="fas fa-trash fa-lg mr-1"></i>
                            </a>';
                }

                $data .='   <a href="#" class="cancel-btn" data-id="'.$row['0'].'" data-adminid="'.$row["user_id"].'">
                                <i class="fas fa-ban fa-lg mr-1"></i>
                            </a>
                            </div>
                        </div>
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
                                    <h6>Order Items: </h6>
                                    <hr>
                                    <h6>Quantity: </h6>
                                </div>
                                <div class="col-md-10"  style="font-style: italic;">
                                    <h6>0000'.$row["0"].'</h6>
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
                    </div>';
            }
            return $data;
        }
        return "NO_DATA_AVAILABLE";
    }

    // Fetch info data for and print in Edit modal
    public function getClientInfo($clientID){
        $sql = "SELECT `name`,`address`,`postal_code` FROM `clients` WHERE `id` = ? ";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("i", $clientID);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $data = $result->fetch_array();

        if ($result->num_rows > 0){
            return json_encode($data);
        }
    }

    // Edit function
    public function editClientInfo($clientID, $name, $address, $zipCode){
        $sql = "UPDATE `clients` SET `name`= ?,`address`= ?,`postal_code`= ? WHERE `id` = ?";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("ssii", $name,$address,$zipCode,$clientID);
        $result = $pre_stmt->execute() or die($this->_CON->error);

        if ($result){
            return 1;
        }
        return "ERROR";
    }

    // Delete the Order
    public function deleteOrder($orderID, $userLoggedInID, $adminID, $itemID, $itemQty) {
        $sql = "DELETE FROM `orders` WHERE `id` = ?";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("i", $orderID);
        $result = $pre_stmt->execute() or die($this->_CON->error);

        if ($result){
            // Update the Reserved stock
            $updateResult = $this->updateTheStock($itemID, $itemQty);

            if ($updateResult){
                $action = "deleted";
                // Logged the action in history
                $result = $this->insertLogged($orderID, $userLoggedInID, $adminID, $action);
                return ($result) ? 1 : 0;
            }
        }
        return "ERROR";
    }

    public function cancelOrder($orderID, $userLoggedInID, $adminID, $itemID, $itemQty){
        $sql = "UPDATE `orders` SET `order_status`= '0' WHERE `id` = ?";
        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("i", $orderID);
        $result = $pre_stmt->execute() or die($this->_CON->error);

        if ($result){
            // Update the Reserved stock
            $updateResult = $this->updateTheStock($itemID, $itemQty);

            if ($updateResult){
                $action = "canceled";
                // Logged the action in history
                $result = $this->insertLogged($orderID, $userLoggedInID, $adminID, $action);
                return ($result) ? 1 : 0;
            }
        }
    }

    // Get all Order records with pagination
    public function getAllOrder($page, $loggedInID, $userType){
        $data = "";
        $record_per_page = 3;
        $start_from_page = ($page - 1) * $record_per_page;

        $sql = "";

        if ($userType == "admin"){
            $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                    WHERE b.id = a.item_id AND c.id = a.client_id
                    AND a.user_id = $loggedInID ORDER BY a.delivery_date DESC LIMIT ?, ?";
        } else {
            $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                    WHERE b.id = a.item_id AND c.id = a.client_id
                    ORDER BY a.delivery_date DESC LIMIT ?, ?";
        }

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("ii", $start_from_page, $record_per_page);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();

        if ($result->num_rows > 0){
            while($row = $result->fetch_array()){
                $data .='<div class="card cd">
                        <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                        <div class="row" style="float:right"><a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal"
                        data-id="'.$row['client_id'].'"><i class="fas fa-edit fa-lg mr-1"></i></a>';

                if ($userType == "admin"){
                    $data.= '<a href="#" class="delete-btn" data-id="'.$row['0'].'" data-adminid="'.$row["user_id"].'">
                            <i class="fas fa-trash fa-lg mr-1"></i>
                            </a>';
                }

                $data.='<a href="#" class="cancel-btn" data-id="'.$row['0'].'" data-adminid="'.$row["user_id"].'">
                        <i class="fas fa-ban fa-lg mr-1"></i>
                        </a></div></div>
                        <div class="card-body cd">
                            <input type="hidden" name="itemID" class="itemID" value="'.$row["item_id"].'" />
                            <input type="hidden" name="itemQty" class="itemQty" value="'.$row["item_qty"].'" />
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
                                    <h6>Order Items: </h6>
                                    <hr>
                                    <h6>Quantity: </h6>
                                </div>
                                <div class="col-md-10"  style="font-style: italic;">
                                    <h6>0000'.$row["0"].'</h6>
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
            $sql = "";
            if ($userType == "admin"){
                $sql = "SELECT * FROM `orders` WHERE `client_id` = $loggedInID";
            } else {
                $sql = "SELECT * FROM `orders`";
            }

            $pre_stmt = $this->_CON->prepare($sql);
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