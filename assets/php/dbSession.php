<?php

/**
 * Created by PhpStorm.
 * User: adminov
 * Date: 06.07.17
 * Time: 12:32
 */
class dbSession
{


    private $mysqli ;
    private $myQuery ;
    private $userLogin ;
    private $startTime ;
    private $currentTime ;
    private $sessionTime ;


    public function __construct($dbHostName,$dbUser,$dbPassword,$dbName)
    {

        $this->mysqli = new mysqli($dbHostName,$dbUser,$dbPassword,$dbName);

        if ($this->mysqli->connect_errno) {
            echo "Can not connect to  MySQL:" . $this->mysqli->connect_error;
        }
        //check table wp_providers in DB - create it if not

        $this->myQuery = "SELECT * FROM wp_providers_session";
        $result = $this->mysqli->query($this->myQuery);

        if ($result) {
            return true;
        } else {

            $this->myQuery = "CREATE TABLE wp_providers_session ( `id` INT(11) AUTO_INCREMENT , `login` VARCHAR(50) , `start_time` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP (), PRIMARY KEY (`id`)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB;";
            $result = $this->mysqli->query($this->myQuery);

            if(!$result) {
                echo "Can not do the db Query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                return false;
            }else {

                return true ;
            }

        }

    }

    /**
     * check current session with user login
     * @return boolean
     */
    public function checkSession()
    {
        $this->myQuery = "SELECT * FROM wp_providers_session";
        $result = $this->mysqli->query($this->myQuery);

        $cntRow = $result->num_rows ; // check session  in db . If yes - not create

        if($cntRow > 0) {
            return true ;
        }else {
            return false;
        } ;

    }

    /**get current session start_time
     * @return Unix session time mark
     */
    public function getSessionUser()
    {
        $this->myQuery = "SELECT * FROM wp_providers_session";
        $result = $this->mysqli->query($this->myQuery);

        $returnList = $result->fetch_all() ;

        $this->userLogin = $returnList[0][1] ;

        return $this->userLogin ;
    }

//    /**get current session start_time
//     * @return string
//     */
//    public function getSessionStartTime()
//    {
//        $this->myQuery = "SELECT * FROM wp_providers_session WHERE wp_providers_session.login = '$this->userLogin'";
//        $result = $this->mysqli->query($this->myQuery);
//
//        $cntRow = $result->num_rows ; // check session  in db . If yes - not create
//        if($cntRow > 0) {
//            $returnList = $result->fetch_all(MYSQLI_ASSOC) ;
//            $this->startTime = $returnList[0]['start_time'] ;
//        }else {
//            $this->startTime = 0 ;
//        } ;
//
//        return $this->startTime ;
//    }

//    /**get current session start_time
//     * @return Unix session time mark
//     */
//    public function getSessionTime()
//    {
//        $time1 = new DateTime($this->getSessionStartTime()) ;
//        $this->startTime = $time1->getTimestamp() ;
//
//        $time2 = new DateTime();
//        $this->currentTime = $time2->getTimestamp();
//
//        $this->sessionTime = $this->currentTime - $this->startTime ;
//
//        return $this->sessionTime ;
//    }


    /** set  session with current user
     * @return boolean
     */

    public function setSession($userName)
    {
            $this->userLogin = $userName ;
            $this->myQuery = "INSERT INTO wp_providers_session (wp_providers_session.login) VALUES ('$this->userLogin') ";
            $result = $this->mysqli->query($this->myQuery);
            if ($result) {
                return true;
            } else {
                echo "Can not insert session parameters  to the DB : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                return false;
            }

    }

    /** destroy session with current user
     * @return boolean
     */
    public function destroySession()
    {
        $this->myQuery = "TRUNCATE TABLE wp_providers_session" ;
        $result = $this->mysqli->query($this->myQuery);
        if ($result) {
            return true;
        } else {
            echo "Can not do the db Query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            return false;
        }

    }



    public function dbCloseConnect() {

        $this->mysqli->close() ;
    }

}
