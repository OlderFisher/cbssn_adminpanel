<?php
/**
 * Created by PhpStorm.
 * User: adminov
 * Date: 04.07.17
 * Time: 14:23
 */

require_once('dbSession.php') ;
require_once('db_params.php') ;

$session = new dbSession($dbHostName,$dbUser,$dbPassword,$dbName) ;
$session->destroySession() ;
$session->dbCloseConnect() ;
