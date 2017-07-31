<?php
    require_once('assets/php/Session.php') ;
    $mySession = new Session() ;
    $mySession::start() ;

        if(!empty($mySession::get('user'))) {
            header('Location:adminboard.php') ;
            exit ;
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin access</title>
    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles -->
    <link href="assets/css/access.css" rel="stylesheet">
</head>

<body>

    <div class="container access-header">
    </div>

    <div class="panel panel-default panel-access">

        <div class="panel-heading panel-primary">
            <h3 class="panel-title">CBSSN admin</h3>
        </div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="">

                <p id="access_alert">Login or Password is incorrect !</p>

                <div class="form-group">
                    <label for="inputLogin" class="col-sm-2 control-label">Login</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputLogin" name="login" <!--value="--><?php /*echo (isset($_POST["login"])) ? $_POST["login"] : null; */?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password" >
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <input type="submit" class="btn btn-default" value="Sign in" name="submit">
                </div>
            </form>
        </div>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php

require_once('assets/php/UserSubmit.php');
require_once('assets/php/db_params.php') ;

if (isset($_POST['submit'])) {

    $currentUser = $_POST['login'];
    $currentPass = MD5($_POST['password']);

    $submit = new UserSubmit($dbHostName,$dbUser,$dbPassword,$dbName);
    $result = $submit->checkUser($currentUser, $currentPass);
    $submit->dbCloseConnect() ;

    if (!$result) {
        echo "<script>"."document.getElementById('access_alert').style.color= '#c93020';"."</script>";
    } else {
        $enter = true;
        echo "<script>"."document.getElementById('access_alert').style.color= '#FFFFFF';"."</script>";
        $_SESSION['user'] = $currentUser ;
        echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=adminboard.php'></HEAD></HTML>";
    }
}
?>