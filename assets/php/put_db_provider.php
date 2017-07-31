<?php
/**
 * Created by PhpStorm.
 * User: aleksandrlilik
 * Date: 25.06.17
 * Time: 22:39
 */

if($_SERVER["REQUEST_METHOD"] == "POST" ){

    require_once('db_params.php');
    require_once('dbDriver.php');

    $key  = $_POST['key'];
    $name = $_POST['name'] ;
    $link = $_POST['link'] ;



    $mysqli = new dbDriver($dbHostName, $dbUser, $dbPassword, $dbName);
    $mysqli->putDbProvider($key, $name, $link) ;

    $mysqli->dbCloseConnect();

}