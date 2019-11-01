function load_data(page){
    const adminID = $("#userLoggedIn").data("id");
    const userType = $("#userLoggedIn").data("usertype");
    $.ajax({
        url: '../includes/process.php',
        method: 'post',
        data: {page:page, getOrderData:1, adminID:adminID, userType:userType},
        success: function (res){

            $("#data").html(res);
            $("li.active").removeClass("active");
            $("#"+page).parent("li").addClass("active");
        }
    })
}

$(document).ready(function (){
    $('.selectpicker').selectpicker();

    // Inventory Filter function
    $(".multi_select").on("click", function (){
        const selectedUserIDs = $(".selectpicker").val();
        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data: {selectedUserIDs:selectedUserIDs},
            success: function (res){
                if (res != "NO_DATA_AVAILABLE"){
                    $("#table-data").html(res);
                } else {
                    $("#data").html("<h2 class='text-center text-danger mt-4'>NO DATA AVAILABLE</h2>");
                }
            }
        })
    });


/*************************************************
*     ____          _
*   / __ \        | |
*  | |  | |_ __ __| | ___ _ __
*  | |  | | '__/ _` |/ _ \ '__|
* | |__| | | | (_| |  __/ |
* \____/|_|  \__,_|\___|_|
*
* ***********************************************/

    // Get all Order data with pagination
    load_data();
    // Get data upon clicking the pagination
    $(document).on("click", ".pagination_link", function(){
        let page = $(this).attr("id");
        $(document).scrollTop(0);
        load_data(page);
    });

    // Filter function
    $("#filter-form").on("submit", function(e){
        e.preventDefault();

        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data:{
                    selectedUsers: $("#selectedUsers").val(),
                    dateFrom: $("#date-from").val(),
                    dateTo: $("#date-to").val(),
                    userType: $("#userLoggedIn").data("usertype")
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
    $(document).on("click", ".edit-btn", function (){
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
    $(document).on("click", ".delete-btn", function(){
        let isDeleteTrue = confirm("Are you sure you want to Delete this Order?");
        if (isDeleteTrue){
            const data = {
                    orderID: $(this).data("id"),
                    userLoggedInID: $("#userLoggedIn").data("id"),
                    adminID: $(this).data("adminid"),
                    itemID: $(".itemID").val(),
                    itemQty: $(".itemQty").val()
                }

            $.ajax({
                url: '../includes/process.php',
                method: 'POST',
                data: data,
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
    // Cancel Order function
    $(document).on("click", ".cancel-btn", function (){
        let isCancelTrue = confirm("Are you sure you want to Cancel this Order?");

        if (isCancelTrue){
            const data = {
                    orderID: $(this).data("id"),
                    userLoggedInID: $("#userLoggedIn").data("id"),
                    adminID: $(this).data("adminid"),
                    itemID: $(".itemID").val(),
                    itemQty: $(".itemQty").val(),
                    cancelOrder:1
                }
            $.ajax({
                url: '../includes/process.php',
                method: 'POST',
                data: data,
                success: function (res){
                    if (res == 1){
                        alert("Order is successfully Canceled!");
                        window.location.href = './orders.php';
                    } else {
                        alert("There's an Error deleting the data!");
                    }
                }
            })
        }
    });
})