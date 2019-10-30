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
            <div class="card cd">
                <div class="card-header pb-0 pt-3 mt-2" style="background-color: transparent;border: 0;">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-6">
                            <div style="float:right;">
                                <select class="selectpicker" multiple data-live-search="true">
                                    <option>Mustard</option>
                                    <option>Ketchup</option>
                                    <option>Relish</option>
                                </select>
                                <button type="submit" class="btn btn-primary" id="multi_select">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-4">
                    <table class="table" id="item_list">
                        <thead>
                        <tr class="">
                            <th scope="col">Item Code: </th>
                            <th scope="col">Description: </th>
                            <th scope="col">Available Stock</th>
                            <th scope="col">Reserved Stock</th>
                            <th scope="col">Overall Stock</th>
                        </tr>
                        </thead>
                        <tbody>

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

    $("#multi_select").on("click", function (){
        console.log($(".selectpicker").val());
    })
})
</script>

<?php include "./includes/global/footer.php";?>