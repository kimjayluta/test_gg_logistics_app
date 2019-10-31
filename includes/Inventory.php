<?php
class Inventory {
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
        $sql = "SELECT a.*,b.*,c.name FROM orders a, items b, clients c WHERE b.id = a.item_id AND c.id = a.client_id IN ($newUserIDs)";
        $pre_stmt = $this->_CON->prepare($sql);
        // $pre_stmt->bind_param("i",array_merge($newUserIDs));
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


}
?>