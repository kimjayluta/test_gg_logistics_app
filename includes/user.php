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
    public function userLogin($usn, $password, $user_type){
        $sql = "";

        if ($user_type !== "costumer"){
            $sql = "SELECT * FROM `users` WHERE `usn` = ?";
        } else {
            $sql = "SELECT * FROM `clients` WHERE `usn` = ?";
        }

        $pre_stmt = $this->_CON->prepare($sql);
        $pre_stmt->bind_param("s",$usn);
        $pre_stmt->execute() or die($this->_CON->error);
        $result = $pre_stmt->get_result();

        if ($result->num_rows < 1){
            return "ERROR";
        } else {
            $row = $result->fetch_assoc();
            if ($password == $row["pass"]){

                if ($user_type !== "costumer"){
                    $_SESSION["user_type"] = $row["user_type"];
                } else {
                    $_SESSION["user_type"] = 'costumer';
                    $_SESSION["userID"] = $row["user_id"];
                }

                $_SESSION["costumerID"] = $row["id"];
                $_SESSION["usn"] = $row["usn"];

                return 1;

            } else {
                return "ERROR";
            }
        }
    }
}
?>