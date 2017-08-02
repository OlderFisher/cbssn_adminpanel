<?php

require_once('assets/php/dbSession.php') ;
require_once('assets/php/db_params.php') ;

$session = new dbSession($dbHostName,$dbUser,$dbPassword,$dbName) ;

if($session->checkSession()) {
    $currentUser = $session->getSessionUser() ;
    $session->dbCloseConnect();
}else {

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
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CBSSN Admin Board</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- Custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">

  </head>
  <body>


  <!-- Header section ------------------------------------------------------------------------------------------------->

  <div class="container-fluid header-custom">
    <a href="http://cbssn.ideom.net/"><img src="assets/img/Logo.JPG"></a>
    <h3 class="header-heading">CURRENT CHANNELS SUBSCRIPTION ADMIN PANEL</h3>

    <div class=" admin-exit">

            <img  src="assets/img/user.png" width="35px" height="35px">
            <p class="user_output"><?php echo ' '.$currentUser; ?></p>
            <a href="http://cbssn.ideom.net/" class="logout-admin-link"><img src="assets/img/exit.jpg" width="40px" height="40px"><span id="logout-link">Logout</span> </a>

    </div>



  </div>

  <!-- End of header section ------------------------------------------------------------------------------------------>


  <!-- Main body ------------------------------------------------------------------------------------------------------>

  <div class="container-fluid main-body-custom">

        <div class="row">

            <!-- ASP scenario providers list section ------------------------------------------------------------------>

             <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 asp-list-container" id="asp-list">

                <div class=" row panel-heading">
                        <div class="col-lg-8 col-md-6">
                            <h4 class="table-title">ASP SCENARIO OUTPUT FOR ZIP : <span id="asp-zipcode-output"></span></h4>
                        </div>
                        <div class="col-lg-4 col-md-6 text-right zip-finder" >
                            <input class="text-center" type="text" name="zipcode" id="findZipCodeIdInput" placeholder="ZIP CODE">
                            <input type="button" id="zipSubmitBtn" class="btn  btn-submit" name="findZipCode" value="Find ">
                        </div>
                </div>

                <table class="table table-hover table-bordered">  <!-- Providers list  output-->
                    <thead class="text-center">
                        <th>#</th>
                        <th>PROVIDER</th>
                        <th>KEY</th>
                        <th>CHANNELS</th>
                        <th>Copy to DB</th>
                    </thead>
                    <tbody id="providersAspListTableBody" />
                </table>                                                            <!-- End of Providers list output-->

                <h4 class="asp-not-response"></h4>

            </div>

            <!--  End of ASP scenario providers list section -------------------------------------------------------------->

            <!-- DB scenario providers list section ------------------------------------------------------------------>

            <div class="col-lg-6  col-md-12 col-sm-12 col-xs-12 db-list-container" id="db-list">

                <div class="panel-heading">
                    <h4 class="table-title">CBSSN PROVIDERS DB LIST</h4>
                </div>

                <table  class="table table-hover table-bordered">  <!-- Providers DB list  output-->
                    <thead class="text-center">
                        <th>#</th>
                        <th>PROVIDER</th>
                        <th>KEY</th>
                        <th>URL</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </thead>
                    <tbody id="providersDBListTableBody"/>
                </table>                                                            <!-- End of Providers DB list output-->

                <h4 class="db-not-response"></h4>

            </div>

            <!--  End of DB scenario providers list section ---------------------------------------------------------->


        </div>

  </div>

  <!-- Modal window for  operation confirmation ----------------------------------------------------------------------->

  <div id="modal_form">     <!-- mo -->

      <div class="modal-header">
        <h5 class="modal-header-text">CBSSN admin </h5><img src="assets/img/cancel.png" id="modal_close">
      </div>
      <div class="modal-text text-center"> </div>
      <div class="operator_name text-center" ></div>
      <div class="url_edit text-center" >
          <form>
            <input type="text" id="urledit" value="" autofocus>
          </form>
      </div>

      <div class="modal-confirm text-center">
          <input type="button" class="btn btn-default" id="btn_ok" value="OK">
          <input type="button" class="btn btn-default" id="btn_cancel" value="Cancel">

      </div>

  </div>
  <div id="overlay"></div><!-- Пoдлoжкa -->


  <!-- End of Modal window -------------------------------------------------------------------------------------------->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/providers_asp_list_output.js"></script>
    <script type="text/javascript" src="assets/js/providers_db_list_output.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>

