<?php
class User {
    private $_CON;

    function __construct(){
        include_once("../database/db.php");
        $db = new Database();
        $this->_CON = $db->connect();

        if ($this->_CON){
            return $this->_CON;
        }
    }

    //  Login Function
    public function userLogin($usn, $password){
        $pre_stmt = $this->_CON->prepare("SELECT * FROM `user_grp` WHERE `usn` = ?");
        $pre_stmt->bind_param("s",$usn);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();

        if ($result->num_rows < 1){
            return "ERROR";
        } else {

            $row = $result->fetch_assoc();
            if ($password == $row["pass"]){

                $_SESSION["userId"] = $row["id"];
                $_SESSION["usn"] = $row["usn"];
                $_SESSION["user_type"] = $row["user_type"];
                return 1;

            } else {
                return "ERROR";
            }
        }
    }
}
?>