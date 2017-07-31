<?php
/**
 * Created by PhpStorm.
 * User: aleksandrlilik
 * Date: 25.06.17
 * Time: 22:11
 */
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['key'])) {

    require_once('db_params.php');
    require_once('dbDriver.php');

    $key = $_POST['key'];

    $mysqli = new dbDriver($dbHostName, $dbUser, $dbPassword, $dbName);
    $mysqli->delDbProvider($key) ;

    $mysqli->dbCloseConnect();

}