<?php
include "../includes/global/header.php";
include "../database/constants.php";
include "../database/db.php";

$userLoggedIn = $_SESSION['userId'];
$userType = $_SESSION["user_type"];

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
            <li>
                <a href="orders.php">Orders List</a>
            </li>

            <li>
                <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
                <ul class="collapse list-unstyled" id="settings">
                    <li>
                        <a href="#">History</a>
                    </li>
                    <li>
                        <a href="#">Log out</a>
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
                                Hi, <span> Admin</span>
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
                                        $sql = "SELECT `id`,`name` FROM `clients` WHERE `user_id` = ?";
                                        $pre_stmt = $_CON->prepare($sql);
                                        $pre_stmt->bind_param("i",$userLoggedIn);
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

            <div id="data"> </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function (){
    $('.selectpicker').selectpicker();

    $("#filter-form").on("submit", function(e){
        e.preventDefault();

        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data:{
                    selectedUsers: $("#selectedUsers").val(),
                    dateFrom: $("#date-from").val(),
                    dateTo: $("#date-to").val()
                },
            success: function (res){
                if (res != "NO_DATA_AVAILABLE"){
                    $("#data").html(res);
                } else {
                    $("#data").html("<h2 class='text-center text-danger mt-4'>NO DATA AVAILABLE</h2>");
                }
            }
        })
    });
})
</script>
<?php include "../includes/global/footer.php";?>