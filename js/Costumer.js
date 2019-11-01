// Get all list of item
function fetchItemList(){
    $.ajax({
        url: '../includes/process.php',
        method: 'POST',
        data: {getItems:1},
        success: function (res){
            if (res != "ERROR"){
                let root = "<option value='0' selected>Select an Item</option>"
                $('.list-item').html(root + res);
            }
        }
    })
}
// Gets the number of available stock
function getAvailableStock(itemID){
    $.ajax({
        url: '../includes/process.php',
        method: 'post',
        data: {itemID:itemID, getStock:1},
        success: function (res){
            $("#available-stock").val(res);
        }
    })
}
// Function to Get all record order with pagination
function load_data(page){
    const clientID = $("#loggedUser").data("id");
    $.ajax({
        url: '../includes/process.php',
        method: 'post',
        data: {page:page,getData:1, clientID:clientID},
        success: function (res){
            $("#data").html(res);

            $("li.active").removeClass("active");
            $("#"+page).parent("li").addClass("active");
        }
    })
}

$(document).ready(function (){
    // Function to get the Item list
    fetchItemList();

    load_data();
    $(document).on("click", ".pagination_link", function(){
        let page = $(this).attr("id");
        $(document).scrollTop(0);
        load_data(page);
    });

    // Get and computes the Available stock of an item and removed the disabled attr in QTY
    $(".list-item").on("change", function(){

        const itemID = $(this).val();
        $("#qty").removeAttr("disabled");
        getAvailableStock(itemID);

    });

    // Submit the order
    $("#save-order").on("click", function(e){
        e.preventDefault();
        const stock = $("#available-stock").val();
        const data = {
                    item: $("#selected-item").val(),
                    qty: $("#qty").val(),
                    costumerID: $("#loggedUser").attr("data-id"),
                    userID: $("#loggedUser").attr("data-user")
                }

        if (data.qty == ""){
            alert("Please input a Quantity!");
            return false;
        }

        if (data.qty > Number(stock)){
            alert("No available stock for that quantity!");
            return false;
        }

        $.ajax({
            url: '../includes/process.php',
            method: 'POST',
            data: data,
            success: function (res){
                if (res == 1){
                    window.location.href = "./order_list.php";
                }
            }
        })
    });
})