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
                <a href="inv_page.php">Inventory</a>
            </li>
            <li>
                <a href="order_list.php">Orders List</a>
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
            <div class="card-header pb-0 pt-3 mb-2" style="background-color: transparent;border: 0;">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" style="float:right">Create a new Order</button>
                    </div>
                </div>
            </div>
            <div class="card cd">
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

<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Make a New Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table">
                <thead class="thead-primary">
                    <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Quantity</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <tr>
                        <td>
                            <select class="form-control list-item">
                                <option>Select an Item</option>
                            </select>
                        </td>
                        <td style="width: 40%;">
                            <input type="number" name="qty" class="form-control qty" required/>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <button type='button' class='btn btn-success btn_add_column' id='add_row'>
                    <i class='fas fa-plus fa-sm'></i>
                </button>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>

function addColumn(elem){
    let j_id = 1;
    let html_code = "";

    j_id = j_id + 1;
    html_code = "<tr id='"+ j_id +"'>";
    html_code += "<td><select class='form-control list-item'><option>Select an Item</option></select></td>";
    html_code += "<td style='width: 40%;'><input type='number' name='qty' class='form-control qty' required/></td>";
    html_code += "<td class='action_btn'><button type='button' class='btn btn-danger remove-row' data-id='"+ j_id +"'> <i class='fas fa-minus'></i></button></td>";
    html_code += "</tr>";
    return $(elem).append(html_code);
}

function fetchItemList(){
    $.ajax({
        url: '../includes/process.php',
        method: 'POST',
        data: {getItems:1},
        success: function (res){
            if (res != "ERROR"){
                let root = "<option value='0'>Select an Item</option>"
                $('.list-item').html(root + res);
            }
        }
    })
}

$(document).ready(function (){

    fetchItemList();

    $("#add_row").on("click", function(){
        addColumn(".table-body");
        fetchItemList();
    });

    $(".table").on("click", ".remove-row", function (){
        const rowID = $(this).data('id');
        $('#'+ rowID).remove();
    });



})
</script>
<?php include "../includes/global/footer.php";?>