<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap Cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Animation CDN  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css">

    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <!-- Google Fonts Cdn -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!-- Jquery Cdn-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <title>Login</title>

    <style>
        .cd2{
            padding: 10px 25px 0 0;
        }
        .input{
            border: 0;
            padding:0;
            border-bottom: 1px solid #b0bec5;
            border-radius: 0;
            width: 406px;
        }
        .input:focus{
            border-bottom: 1px solid black;
            box-shadow: none;
        }
        .form-group{
            margin-bottom: 2.5rem;
        }
        .buton{
            background-color: black;
            color: white;
        }
        .buton:hover{
            background-color: #343a40;
        }
    </style>

</head>
<body style="font-family: 'Montserrat', sans-serif;">

    <section>
        <div class="container mt-4" style="padding: 3rem 20rem 0 20rem;">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                                <h5>Already Registered ? </h5>
                            <small>If you have an account, sign in with your username</small>
                        </div>
                        <div class="col-2 cd2">
                            <i class="fas fa-user-cog fa-2x" style="float: right"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="loginForm" onsubmit="return false;">
                        <div class="form-group row" style="margin-top: 13px;">
                            <label for="username" class="col-sm-1 col-form-label" style="text-align: right;padding: 0;">
                                <i class="fas fa-user"></i>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input" name="username" id="username" placeholder="Username* " autocomplete="off">
                                <small class="text-muted" id="usn_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-1 col-form-label"style="text-align: right;padding: 0;">
                                <i class="fas fa-unlock"></i>
                            </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control input" name="password" id="password" placeholder="Password* " autocomplete="off">
                                <small class="text-muted" id="pass_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-1 col-form-label"style="text-align: right;padding: 0;">
                                <i class="fas fa-user"></i>
                            </label>
                            <div class="col-sm-10">
                                <select name="user_type" id="user_type" class="form-control ">
                                    <option value="admin">Admin</option>
                                    <option value="csr">Costumer Service</option>
                                    <option value="costumer">Costumer</option>
                                </select>
                                <small class="text-muted" id="userType_error"></small>
                            </div>
                        </div>
                        <button type="submit" class="btn buton w-100" id="btn-submit">Login</button>
                        <div class="form-group mt-1 row" style="margin-bottom: 0">
                            <div class="col" style="text-align: right">
                                <small><a href="#"> Forgot Password ? </a></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="./js/main.js"></script>

    <!--Bootstrap Cdn Js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
