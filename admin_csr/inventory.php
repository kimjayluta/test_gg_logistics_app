<?php
include "../includes/global/header.php";
include "../database/constants.php";
include "../database/db.php";

// Restriction not to be visit by costumer user.
if (isset($_SESSION["user_type"])){
    if ($_SESSION["user_type"] == 'costumer'){
        header("location: ../");
        exit;
    }
}
$userLoggedIn = $_SESSION['userID'];
$_CON = new Database();
$_CON = $_CON->connect();

?>

<title>Dashboard</title>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Logistic_App</h4>
        </div>
        <ul class="list-unstyled components">
            <li class="active">
                <a href="inventory.php">Inventory</a>
            </li>
            <li>
                <a href="orders.php">Orders List</a>
            </li>

            <li>
                <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
                <ul class="collapse list-unstyled" id="settings">
                    <li>
                        <a href="history.php">History</a>
                    </li>
                    <li>
                        <a href="../includes/process.php?logout">Log out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- Page Content  -->
    <div id="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-dark" style="border-radius: 20px;">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">
                                Hi, <span><?php echo ucfirst($_SESSION["usn"]);?></span>
                                <i class="fas fa-user-circle fa-lg"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!--Content here-->
        <div class="container">
            <div class="card cd">
                <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-6">
                            <div style="float:right;">
                                <select class="selectpicker" multiple data-live-search="true">
                                    <?php
                                        $sql = "";
                                        if ($_SESSION["user_type"] == "admin"){
                                            $sql = "SELECT `id`,`name` FROM `clients` WHERE `user_id` = $userLoggedIn";
                                        } else {
                                            $sql = "SELECT `id`,`name` FROM `clients`";
                                        }
                                        $pre_stmt = $_CON->prepare($sql);
                                        $pre_stmt->execute() or die ($_CON->error());
                                        $result = $pre_stmt->get_result();

                                        while ($row = $result->fetch_array()){
                                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-primary multi_select">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-4">
                    <table class="table" id="item_list">
                        <thead>
                        <tr class="">
                            <th scope="col">Item Code</th>
                            <th scope="col">Product</th>
                            <th scope="col">Available Stock</th>
                            <th scope="col">Reserved Stock</th>
                            <th scope="col">Overall Stock</th>
                            <th scope="col">Order By</th>
                        </tr>
                        </thead>
                        <tbody id="table-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/Admin_csr.js"></script>
<?php include "../includes/global/footer.php";?>