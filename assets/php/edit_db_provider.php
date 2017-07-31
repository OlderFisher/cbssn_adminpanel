<?php
/**
 * Created by PhpStorm.
 * User: aleksandrlilik
 * Date: 27.06.17
 * Time: 15:40
 */


if($_SERVER["REQUEST_METHOD"] == "POST" ){

    require_once('db_params.php');
    require_once('dbDriver.php');

    $key  = $_POST['key'];
    $link = $_POST['link'] ;




    $mysqli = new dbDriver($dbHostName, $dbUser, $dbPassword, $dbName);
    $mysqli->editDbProvider($key, $link) ;

    $mysqli->dbCloseConnect();

}