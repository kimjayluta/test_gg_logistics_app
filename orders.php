<?php
include "./includes/global/header.php";
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

            <div class="row">
                <div class="col-2">
                    <div class="dropdown mb-4 w-100">
                        <button class="btn btn-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="">Filter by</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Choose a Client...</a>
                            <a class="dropdown-item" href="#">Delivery Time...</a>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>

            <div class="card">
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

            <div class="card">
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