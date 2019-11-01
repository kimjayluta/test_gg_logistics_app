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
            <li>
                <a href="orders.php">Orders List</a>
            </li>

            <li class="active">
                <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle ">Settings</a>
                <ul class="collapse list-unstyled" id="settings">
                    <?php
                    if ($_SESSION["user_type"] == "admin"){
                        echo '<li><a href="history.php" class="active">History</a></li>';
                    }
                    ?>
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

                </div>
                <div class="card-body mt-4">
                    <table class="table" id="item_list">
                        <thead>
                        <tr class="">
                            <th scope="col">User</th>
                            <th scope="col">Action</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                        </thead>
                        <tbody id="history-data">

                            <?php
                                $sql = "SELECT a.*, b.usn
                                        FROM history a, users b
                                        WHERE a.admin_id = ?
                                        AND a.user_id = b.id
                                        ORDER BY a.date_action DESC";
                                $pre_stmt = $_CON->prepare($sql);
                                $pre_stmt->bind_param("i", $userLoggedIn);
                                $pre_stmt->execute() or die($_CON->error);
                                $result = $pre_stmt->get_result();

                                if ($result->num_rows > 0){
                                    while ($row = $result->fetch_array()){
                                        echo
                                        '
                                            <tr>
                                                <td>'.$row["usn"].'</td>
                                                <td>'.ucfirst($row["user_action"]).'</td>
                                                <td>'.$row["order_id"].'</td>
                                                <td>'.$row["date_action"].'</td>
                                            </tr>
                                        ';
                                    }

                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "../includes/global/footer.php";?>