<?php
include "../includes/global/header.php";
include "../database/constants.php";

// Restriction not to be visit by admin/csr user.
if (isset($_SESSION["user_type"])){
    if ($_SESSION["user_type"] != 'costumer'){
        header("location: ../");
        exit;
    }
}

$costumerID = $_SESSION['costumerID'];
$userID = $_SESSION["userID"];

include "../database/db.php";
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
            <li class="active">
                <a href="order_list.php">Orders List</a>
            </li>

            <li>
                <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
                <ul class="collapse list-unstyled" id="settings">
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
                                Hi, <span id="loggedUser" data-id="<?php echo $costumerID;?>" data-user="<?php echo $userID;?>">
                                <?php echo ucfirst($_SESSION["usn"]); ?></span>
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
            <div id="data"></div>
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
        <small id="qty-error"></small>
        <table class="table">
            <thead class="thead-primary">
                <tr>
                <th scope="col">Item</th>
                <th scope="col">Quantity</th>
                <th scope="col">Available Stock</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr>
                    <td class="item">
                        <select class="form-control list-item" id="selected-item" required></select>
                    </td>
                    <td style="width: 30%;">
                        <input type="number" name="qty" class="form-control" id="qty" required disabled/>
                    </td>
                    <td style="width: 20%;">
                        <input type="number" name="available-stock" id="available-stock" class="form-control qty" disabled/>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-order">Order</button>
      </div>
    </div>
  </div>
</div>

<script src="../js/Costumer.js"></script>
<?php include "../includes/global/footer.php";?>