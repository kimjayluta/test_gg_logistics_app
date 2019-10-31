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
                <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-6">
                            <div style="float:right;">
                                <select class="selectpicker" multiple data-live-search="true">
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

<script>
$(document).ready(function (){
    $('.selectpicker').selectpicker();

    $(".multi_select").on("click", function (){
        const selectedUserIDs = $(".selectpicker").val();

        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data: {selectedUserIDs:selectedUserIDs},
            success: function (res){
                $("#table-data").html(res);
            }
        })
    });
})
</script>

<?php include "../includes/global/footer.php";?>