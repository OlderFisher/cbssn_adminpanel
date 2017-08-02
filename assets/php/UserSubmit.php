<?php
/**
 * Created by PhpStorm.
 * User: Alex Lilik
 * Date: 21.06.2017
 * Time: 22:26
 */


class UserSubmit
{
	private $user = "";
	private $password = "";

	private $bdUser ;
	private $bdPassword ;


    public function __construct($dbHostName,$dbUser,$dbPassword,$dbName)
    {

        $this->mysqli = new mysqli($dbHostName,$dbUser,$dbPassword,$dbName);

        if ($this->mysqli->connect_errno) {
            echo "Cant connect to  MySQL: " . $this->mysqli->connect_error;
        }
        //check table wp_providers in DB - create it if not

        $this->myQuery = "SELECT * FROM wp_providers_users";
        $result = $this->mysqli->query($this->myQuery);

        if ($result) {
            return true;
        } else {
            $this->myQuery = "CREATE TABLE wp_providers_users ( `id` INT  AUTO_INCREMENT , `name` VARCHAR(50) , `pass` VARCHAR(50), PRIMARY KEY (`id`)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB;";
            $result = $this->mysqli->query($this->myQuery);

            if(!$result) {
                echo "Can not do the DB Query : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                return false;
            }else {
                $usersArray = array (
                    array ('NAME' => 'aleksandr', 'PASSWORD' => MD5('password')),
                    array ('NAME' => 'Wilson', 'PASSWORD' => MD5('bu(r8Xv0LahYt#obrE#XkNcq')),

                ) ;
                foreach ($usersArray as $item => $value) {
                    $name = $value['NAME'] ;
                    $pass = $value['PASSWORD'] ;
                    $this->myQuery =   "INSERT INTO wp_providers_users (wp_providers_users.name,wp_providers_users.pass) VALUES ('$name','$pass')" ;
                    $res = $this->mysqli->query($this->myQuery);
                }

                return true ;
            }

        }
    }
    /**
     * @param $currentUser
     * @param $currentPass
     * @return bool
     */
    public function checkUser($currentUser, $currentPass)
	{
	    $this->user = $currentUser ;
	    $this->password = $currentPass ;

        $this->myQuery = "SELECT * FROM wp_providers_users WHERE name='{$this->user}'"	;
        $result = $this->mysqli->query($this->myQuery);


       /* if (!$result) {
            echo "Could not successfully run query ($this->myQuery) from DB: " . mysqli_error();
            exit;
        }*/

        if (mysqli_num_rows($result) == 0) {
            return false ;
        }

        $queryResArray = $result->fetch_row() ;


        if(!empty($queryResArray)) {
            $this->bdUser = $queryResArray[1];
            $this->bdPassword = $queryResArray[2];
        }else {
            $this->bdUser = 'Empty';
            $this->bdPassword = 'Empty';
        }


		if(($this->user == $this->bdUser) && ($this->password == $this->bdPassword) ){
			// Запись в сессию
			return  true  ;
		}else {
			return false ;
		}
	}

    /**
     * @return string
     */
    public function getUser($currentUser)
    {
        $this->user = $currentUser ;

        $this->myQuery = "SELECT * FROM wp_providers_users WHERE name='{$this->user}'"	;
        $result = $this->mysqli->query($this->myQuery);


        if (mysqli_num_rows($result) == 0) {
            return false ;
        }

        return true;
    }

    public function dbCloseConnect() {

        $this->mysqli->close() ;
    }

}


