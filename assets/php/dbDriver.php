<?php

/**
 * Created by PhpStorm.
 * User: Alex Lilik
 * Date: 15.11.2016
 * Time: 8:56
 *
 * Here is class for
 *  - XML Files Data Base storage and working
 *  - Data Base is MySQL
 *
 */
class dbDriver
{


	private $mysqli ;
	private $myQuery ;


	public function __construct($dbHostName,$dbUser,$dbPassword,$dbName)
	{

		$this->mysqli = new mysqli($dbHostName,$dbUser,$dbPassword,$dbName);

		if ($this->mysqli->connect_errno) {
			echo "Can not connect to  MySQL: " . $this->mysqli->connect_error;
		}
		//check table wp_providers in DB - create it if not

        $this->myQuery = "SELECT * FROM wp_providers";
        $result = $this->mysqli->query($this->myQuery);

        if ($result) {
            return true;
        } else {
            $this->myQuery = "CREATE TABLE wp_providers ( `id` INT  AUTO_INCREMENT , `name` VARCHAR(50) , `key` VARCHAR(50)  , `link` VARCHAR(100)  , PRIMARY KEY (`id`)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB;";
            $result = $this->mysqli->query($this->myQuery);

            if(!$result) {
                echo "Can not do the db Query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                return false;
            }else {
                $providersArray = array (
                    array ('NAME' => 'Buckeye Cable System', 'KEY' => 'BUCKEYECABLESYSTEM','LINK' => 'https://www.buckeyebroadband.com/tveverywhere'),
                    array ('NAME' => 'Cox Communication',    'KEY' => 'COXCOMMUNICATIONS', 'LINK' => 'https://www.cox.com/residential/tv/watch-tv-online.html'),
                    array ('NAME' => 'Cox',                  'KEY' => 'COX',               'LINK' => 'https://www.cox.com/residential/tv/watch-tv-online.html'),
                    array ('NAME' => 'FiOS TV from Frontier','KEY' => 'FIOSTVFROMFRONTIER','LINK' => 'https://tv.frontier.com/'),
                    array ('NAME' => 'MEDIACOM',             'KEY' => 'MEDIACOM',          'LINK' => 'http://watch.mediacomtoday.com/'),
                    array ('NAME' => 'Optimum',              'KEY' => 'OPTIMUM',           'LINK' => 'https://www.optimum.net/tv/to-go/'),
                    array ('NAME' => 'WOW',                  'KEY' => 'WOW',               'LINK' => 'http://www.wowway.com/products/tv#tv-online'),
                ) ;

                foreach ($providersArray as $item => $value) {
                  $name = $value['NAME'] ;
                  $key = $value['KEY'] ;
                  $link = $value['LINK'] ;

                  $this->myQuery =   "INSERT INTO wp_providers (wp_providers.name,wp_providers.key,wp_providers.link) VALUES ('$name','$key','$link')" ;
                  $res = $this->mysqli->query($this->myQuery);

                }

                return true ;
            }

        }

    }

    public function readDbList(){

        $this->myQuery = "SELECT * FROM wp_providers ORDER BY wp_providers.key" ;
        $result = $this->mysqli->query($this->myQuery);


        $returnList = $result->fetch_all(MYSQLI_ASSOC) ;

        return $returnList ;

    }

    /**
     * @return mixed
     */
    public function delDbProvider($key)
    {
        $this->myQuery = "DELETE FROM wp_providers WHERE wp_providers.key = '$key'" ;
        $result = $this->mysqli->query($this->myQuery);
        if ($result) {
            return true;
        } else {
            echo "Can not connect  to the db Provider: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function putDbProvider($key, $name, $link)
    {

        $this->myQuery = "SELECT * FROM wp_providers WHERE wp_providers.key = '$key'";
        $result = $this->mysqli->query($this->myQuery);

        $cntRow = $result->num_rows ; // check provider in db list. If yes - not copy
        if($cntRow > 0) {
            return true ;
        }else {
            $this->myQuery = "INSERT INTO wp_providers (wp_providers.name,wp_providers.key,wp_providers.link) VALUES ('$name','$key','$link') ";
            $result = $this->mysqli->query($this->myQuery);
            if ($result) {
                return true;
            } else {
                echo "Can not  do the db Query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                return false;
            }
        }
    }

    public function editDbProvider($key, $link)
    {
        $this->myQuery = "UPDATE wp_providers SET wp_providers.link='$link' WHERE wp_providers.key = '$key'" ;
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