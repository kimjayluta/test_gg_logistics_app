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
            <li>
                <a href="inventory.php">Inventory</a>
            </li>
            <li class="active">
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
                                Hi, <span id="userLoggedIn" data-id="<?php echo $userLoggedIn?>"
                                data-usertype="<?php echo $_SESSION["user_type"]?>">
                                    <?php echo ucfirst($_SESSION["usn"]);?>
                                </span>
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
                <div class="card-body">

                    <form id="filter-form" onsubmit="return false;">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Clients: </label>
                            <div class="col-sm-10">
                                <select class="selectpicker" multiple data-live-search="true" id="selectedUsers" name="selectedUsers" required>
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Date From: </label>
                            <div class="col-sm-4">
                                <input type="date" name="date-from" id="date-from" class="form-control" required/>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">To: </label>
                                    <div class="col-sm-10">
                                        <input type="date" name="date-to" id="date-to" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary multi_select">Submit</button>
                    </form>

                </div>
            </div>
            <div id="data"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Order: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" onsubmit="return false;">
                    <input type="hidden" id="clientID" name="clientID" value="">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name* </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Address* </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipCode" class="col-sm-3 col-form-label">Zip Code*</label>
                        <div class="col">
                            <input type="number" class="form-control" id="zipCode" name="zipCode" value="">
                        </div>
                    </div>
                    <div class="form-group" style="float: right;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/Admin_csr.js"></script>
<?php include "../includes/global/footer.php";?>