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

    public function getUserItem($userIDs = array()){
        $newUserIDs = implode(", ",$userIDs);

        $sql = "SELECT a.*,b.*,c.name FROM orders a, items b, clients c
                WHERE b.id = a.item_id AND c.id = a.client_id
                AND a.client_id IN ($newUserIDs)";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $rows = array();

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $availableStock = $row["qty_stock"] - $row["reserved_stock"];
                $table = '
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

    public function getUserOrder($userIDs, $dateFrom, $dateTo) {
        $newUserIDs = implode(",",$userIDs);

        $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                WHERE a.delivery_date BETWEEN '$dateFrom' AND '$dateTo'
                AND b.id = a.item_id
                AND c.id = a.client_id
                AND a.client_id IN ($newUserIDs)";

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();
        $rows = array();
        $data = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){

                $data .=
                '
                    <div class="card cd">
                        <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                            <div class="row" style="float:right">
                                <a href="#">
                                    <i class="fas fa-edit fa-lg mr-1"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash fa-lg mr-1"></i>
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
                                    <h6>Ordered Date: </h6>
                                    <hr>
                                    <h6>Order Items: </h6>
                                    <hr>
                                    <h6>Quantity: </h6>
                                </div>
                                <div class="col-md-10"  style="font-style: italic;">
                                    <h6>0000'.$row["id"].'</h6>
                                    <hr>
                                    <h6>'.$row["name"].'</h6>
                                    <hr>
                                    <h6>'.$row["address"].'</h6>
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
            return $data;

        }
        return "NO_DATA_AVAILABLE";

    }


}
?>