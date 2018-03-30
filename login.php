<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/18/17
 * Time: 4:17 PM
 */
session_start();
class connectionl
{
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

        $connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($connection->connect_error) {
            die("error in connection" . $connection->connect_error);
        }
        $this->query1 = $connection;

    }
}

$mov= new connectionl;
class login1 extends connectionl {
    public $email;
    public $pass;
    public $user;

    public function free($data){

        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        $data= $this->query1->real_escape_string($data);
        return $data;
    }
     public function getval(){
        $this->email=$this->free($_POST['email']);
        $this->pass=$_POST['pass'];

         $sql1= "SELECT * FROM Users WHERE Mail='$this->email'";
        $result=$this->query1->query($sql1);


        if ($result->num_rows==0){
            $_SESSION['message']= "user with that email does not exist";
            header("location:error.php");
        }
        else{
            $this->user=$result->fetch_assoc();
            $this->sign();
        }

     }

     public function sign(){
         if (password_verify($this->pass, $this->user['password'])){
             $_SESSION['name']=$this->user['Name'];

             if ($this->user['Active']>0){
                 header("location:loginhome.html");

             }
             else {

                 $_SESSION['message']="confirmation link has been sent to $this->email, please verify your
                account by clicking on the link in the message";
                 header('location:success.php');
             }

         }
         else{
             $_SESSION['message']= "you have entered the wrong password";
             header('location:error.php');
         }

     }
}
$abj= new login1;
$abj->getval();
?>

