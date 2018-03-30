<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/1/17
 * Time: 10:26 PM
 */
session_start();
class connectionV{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public $query1;
    //connect to the database
    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "franc";
        $this->password = "come1234";
        $this->dbname = "quest";

        $connection= new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($connection->connect_error) {
            die("error in connection".$connection->connect_error);}
        $this->query1=$connection;

    }

    //query the db
    public function query($sql){

        $this->query1->query($sql);

    }

}
$dev = new connectionV;
class verify extends connectionV{
    public $email;
    public $hash;
    public $result;
   /* public function free($data){

        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        $data= mysql_real_escape_string($data);
        return $data;
    }*/
    public function very(){
         if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {

             $this->email = $_GET['email'];
             $this->hash = $_GET['hash'];
             //echo $this->email . $this->hash;

             $this->result= $this->query1->query("SELECT * FROM Users WHERE Mail='$this->email' AND Hash='$this->hash' AND Active='0' ");

             if ($this->result->num_rows >0){
                 $_SESSION['message']= "your account has be successfully activated";
                 $this->query("UPDATE Users SET Active='1' WHERE Mail='$this->email'");


                 header("location:success.php");

             }
             else{
                 $_SESSION['message']= "Account has already been activated or  the url is Invalid";
                 header("location:error.php");
             }


         }

         else{
             $_SESSION['message']= "Invalid parameters provided for account verification";
             header("location:error.php");
         }

    }

}
$emi= new verify;
$emi->very();
?>