<?php
/**
 * Created by PhpStorm.
 * User: adminov
 * Date: 04.07.17
 * Time: 14:23
 */

    require_once('Session.php') ;
    $mySession = new Session() ;
    $mySession::start() ;
    $mySession::destroy() ;
    $mySession::start() ;





