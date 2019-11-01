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
                                Hi, <span id="userLoggedIn" data-id="<?php echo $userLoggedIn?>">
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

            <div id="data">
                <?php
                    $sql = "SELECT a.*,b.*,c.* FROM orders a, items b, clients c
                    WHERE b.id = a.item_id AND c.id = a.client_id
                    AND a.user_id = ? ORDER BY a.delivery_date DESC";

                    $pre_stmt = $_CON->prepare($sql);
                    $pre_stmt->bind_param("i", $userLoggedIn);
                    $pre_stmt->execute() or die($_CON->error);
                    $result = $pre_stmt->get_result();

                    if ($result->num_rows > 0){
                        while($row = $result->fetch_array()){

                            echo
                            '
                                <div class="card cd">
                                    <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                                        <div class="row" style="float:right">
                                            <a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal"
                                            data-id="'.$row['client_id'].'">
                                                <i class="fas fa-edit fa-lg mr-1"></i>
                                            </a>
                                            <a href="#" class="delete-btn" data-id="'.$row['0'].'">
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
                                                <h6>Zip Code: </h6>
                                                <hr>
                                                <h6>Ordered Date: </h6>
                                                <hr>
                                                <h6>Order Items: </h6>
                                                <hr>
                                                <h6>Quantity: </h6>
                                            </div>
                                            <div class="col-md-10"  style="font-style: italic;">
                                                <h6>'.$row["0"].'</h6>
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
                    }
                ?>
            </div>
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

<!-- Delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Order: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function (){
    $('.selectpicker').selectpicker();

    // Filter function
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

    // On click the edit icon, fetch the data and print in modal
    $("#data").find(".edit-btn").on("click", function (){
        const clientID = $(this).data("id");
        $.ajax({
            url: '../includes/process.php',
            method: 'post',
            data: {clientID:clientID, getClientInfo:1},
            success: function (data){
                const clientInfo = JSON.parse(data);
                $("#clientID").val(clientID);
                $("#name").val(clientInfo["name"]);
                $("#address").val(clientInfo["address"]);
                $("#zipCode").val(clientInfo["postal_code"]);
            }
        })
    });

    // Edit Function
    $("#edit-form").on("submit", function (e){
        e.preventDefault();
        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data: $("#edit-form").serialize(),
            success: function (res){
                if (res == 1){
                    alert("Data is successfully Updated");
                    window.location.href = './orders.php';
                } else {
                    alert("There's an Error updating the data!");
                }
            }
        })
    });

    // Delete Function
    $(".delete-btn").on("click", function(){
        let isDeleteTrue = confirm("Are you sure you want to Delete this Order?");
        if (isDeleteTrue){
            const dataID = $(this).data("id");
            $.ajax({
                url: '../includes/process.php',
                method: 'POST',
                data: {dataID:dataID, deleteData:1},
                success: function (res){
                    if (res == 1){
                        alert("Data is successfully Deleted!");
                        window.location.href = './orders.php';
                    } else {
                        alert("There's an Error deleting the data!");
                    }
                }
            })
        }
    });
})
</script>
<?php include "../includes/global/footer.php";?>