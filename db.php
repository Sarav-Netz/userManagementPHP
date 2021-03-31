<?php
    class dbConnection{
        private $serverName="localhost";  #  this is hostName
        private $userName="root";    # this the user name for the database
        private $userPass="root";    #this is the password for the user database  
        private $dbName="usermanagement";    #this is the official name of our database
        public $con = FALSE;
        #this method will try to connect database for the different purposes;
        public function connectDb(){
            try{
                $this->con = mysqli_connect($this->serverName,$this->userName,$this->userPass,$this->dbName);
                // echo "i'm established";
                return $this->con;
            }
            catch(mysqli_sql_exception $eroor){
                throw $error;
            }
        }
        # this will dissconnect database 
        public function dissconnectDb(){
            $this->con = NULL;
            // echo "i'm disconnected";
            return $this->con;
        }
    }
    class createQuery{#this class will generate queries for the different tasks;
        public $myQuery;
        private $tableName = 'workmate';
        //this method will add new user into our database
        public function addUserQuery($name,$email,$role,$password){
            $this->myQuery="INSERT INTO `$this->tableName` (`userName`, `userEmail`, `userRole`, `userPassword`) VALUES ('$name', '$email','$role','$password');";
            return $this->myQuery;
        }
        //This will select all the User fot the Admin
        public function selectAllUserQuery(){
            $this->myQuery="SELECT * FROM $this->tableName";
            return $this->myQuery;
        }
        #select any user on the basis of userId
        public function selectWithCond($condition){
            $this->myQuery="SELECT * FROM $this->tableName WHERE userId=$condition";
            return $this->myQuery;
        }
        #this method will help end user and admin to change the info the users;
        public function updateInfoQuery($userId,$name,$email){
            $this->myQuery= "UPDATE $this->tableName SET `userName` = '$name', `userEmail`= '$email' WHERE $this->tableName.`userId` = $userId;";
            return $this->myQuery;
        }
        #this method will help tp change the password of the users;
        public function updatePassword($userId,$userPassword){
            $this->myQuery="UPDATE `$this->tableName` SET `userPassword` = '$userPassword' WHERE `workmate`.`userId` = $userId;";
        }
        #this will delete an end user from the database
        public function deleteQuery($userId){
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`userId`=$userId";
            return $this->myQuery;
        }
    }
    // echo "<h3>Hey buddy!,,,I'm from database connectivity page and this page is working perfectluy.</h3>"
?>