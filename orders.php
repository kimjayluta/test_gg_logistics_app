<?php
include "./includes/global/header.php";
include "./database/constants.php";
include "./database/db.php";

$userLoggedIn = $_SESSION['userId'];
$userType = $_SESSION["user_type"];

$_CON = new Database();
$_CON = $_CON->connect();

?>
<title>Dashboard</title>
<div class="wrapper">
    <!-- Sidebar  -->
    <?php include "./includes/global/side_nav.php"?>
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Date From: </label>
                            <div class="col-sm-4">
                                <input type="date" name="date-from" id="date-from" class="form-control">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">To: </label>
                                    <div class="col-sm-10">
                                        <input type="date" name="date-from" id="date-from" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary multi_select">Submit</button>
                    </form>
                </div>
            </div>

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
                            <h6>To Received: </h6>
                            <hr>
                            <h6>Order Items: </h6>
                        </div>
                        <div class="col-md-10"  style="font-style: italic;">
                            <h6>#00001</h6>
                            <hr>
                            <h6>Kim</h6>
                            <hr>
                            <h6>Naga City</h6>
                            <hr>
                            <h6>07/21/1998</h6>
                            <hr>
                            <ul class="order-list">
                                <li class="list-item">Samsung</li>
                                <li class="list-item">Samsung</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

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
                            <h6>To Received: </h6>
                            <hr>
                            <h6>Order Items: </h6>
                        </div>
                        <div class="col-md-10"  style="font-style: italic;">
                            <h6>#00001</h6>
                            <hr>
                            <h6>Kim</h6>
                            <hr>
                            <h6>Naga City</h6>
                            <hr>
                            <h6>07/21/1998</h6>
                            <hr>
                            <ul class="order-list">
                                <li class="list-item">Samsung</li>
                                <li class="list-item">Samsung</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include "./includes/global/footer.php";?>