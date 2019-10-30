$(document).ready(function (){

    /*
    /$$                           /$$                  /$$$$$$  /$$   /$$   /$$     /$$
    | $$                          |__/                 /$$__  $$| $$  | $$  | $$    | $$
    | $$        /$$$$$$   /$$$$$$  /$$ /$$$$$$$       | $$  \ $$| $$  | $$ /$$$$$$  | $$$$$$$
    | $$       /$$__  $$ /$$__  $$| $$| $$__  $$      | $$$$$$$$| $$  | $$|_  $$_/  | $$__  $$
    | $$      | $$  \ $$| $$  \ $$| $$| $$  \ $$      | $$__  $$| $$  | $$  | $$    | $$  \ $$
    | $$      | $$  | $$| $$  | $$| $$| $$  | $$      | $$  | $$| $$  | $$  | $$ /$$| $$  | $$
    | $$$$$$$$|  $$$$$$/|  $$$$$$$| $$| $$  | $$      | $$  | $$|  $$$$$$/  |  $$$$/| $$  | $$
    |________/ \______/  \____  $$|__/|__/  |__/      |__/  |__/ \______/    \___/  |__/  |__/
                        /$$  \ $$
                        |  $$$$$$/
                        \______/
    */

    $("#loginForm").on("submit", function() {
        let usn = $("#username");
        let pass = $("#password");
        let userType = $("#user_type");
        let isEmptySpace = "^\\s+$";

        if (usn.val().trim() == "" || pass.val().trim() == ""){

            $("#username").addClass("border-bottom border-danger");
            $("#usn_error").html("<span class='text-danger'> All fields are required! </span>");

            $("#password").addClass("border-bottom border-danger");
            $("#pass_error").html("<span class='text-danger'> All fields are required! </span>");

            return false;
        }

        $("#username").removeClass("border-bottom border-danger");
        $("#usn_error").html("");

        $.ajax({
            url: '../includes/process.php',
            method: "POST",
            data: $("#loginForm").serialize(),
            success: function (res){
                if (res == "ERROR"){

                    $("#username").addClass("border-bottom border-danger");
                    $("#usn_error").html("<span class='text-danger'> Error Username or Password! Please try again.</span>");

                    $("#password").addClass("border-bottom border-danger");
                    $("#pass_error").html("<span class='text-danger'> Error Username or Password! Please try again.</span>");

                } else {
                    window.location.href = encodeURI("./inventory.php");
                }
            }
        })
    });
})