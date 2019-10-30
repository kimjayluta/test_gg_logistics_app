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
}



?>