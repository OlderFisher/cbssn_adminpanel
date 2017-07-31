<?php
/**
 * Created by PhpStorm.
 * User: aleksandrlilik
 * Date: 25.06.17
 * Time: 09:47
 */

if($_SERVER["REQUEST_METHOD"] == "POST" ) {

    require_once('db_params.php');
    require_once('dbDriver.php');

    $mysqli = new dbDriver($dbHostName, $dbUser, $dbPassword, $dbName);
    $result = $mysqli->readDbList();
    $mysqli->dbCloseConnect();

    echo json_encode($result);

}