<?php
session_start();
class connection{
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
//instantiate the class to connect
$obf =new connection;

class Get extends connection {
    public $fname;
    public $email;
    public $pasword;
    public $telno;
    public $hash;
    public $active= 0;

    public function free($data){

        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        $data= $this->query1->real_escape_string($data);
        return $data;
    }
    //get user info
    public function construct(){

        $this->fname=$this->free($_POST["fname"]);
        $this->email=$this->free($_POST['email']);
        $this->pasword= password_hash($_POST['pass'], PASSWORD_BCRYPT);
        //$this->pasword=isset($_POST["pass"]) ? $_POST["pass"] :null;
        $this->telno=$this->free($_POST["telo"]);
        $this->hash= md5(rand(0,10000));
    }
    //make a little validation

    protected function check(){
        if (empty($this->fname)  || empty($this->pasword) || empty($this->telno)){
            throw new exception("please fill in the information");
            //return false;
        }
        elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
           throw new exception('invalid email');
            //return false;
        }
    }
    //protect the database from injections


    /*public function free2(){



            $this->fname = $this->free($this->fname);
            $this->email = $this->free($this->email);
           // $this->pasword = $this->free($this->pasword);
            $this->telno = $this->free($this->telno);
            //$this->hash= $this->free($this->hash);


    }*/

    public function check1(){

        $sql1= "SELECT * FROM Users WHERE Mail='$this->email'";

        $result=$this->query1->query($sql1);

        if ($result->num_rows >0){
            $_SESSION['error']="The Email has  already been used";
            header("location: signup.php" );
        }
        else{

            $this->upload();
        }
    }


    protected $mailrun= "origin";

    //insert data
    public function upload(){
        $this->query(
        "INSERT INTO Users (Mail, Name, password, Telephone, Hash, Active)
            VALUES('$this->email',' $this->fname','$this->pasword','$this->telno','$this->hash','$this->active')");

        $this->mailrun="worked";
    }



    public function mail(){
        if ($this->mailrun ==='worked'){

            $_SESSION['message']=
                " confirmation link has been sent to $this->email, please verify your
                account by clicking on the link in the message";

            require 'PHPMailer5.2.0/class.phpmailer.php';


            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "tsl";                 // sets the prefix to the servier
            $mail->Host       = "smtp.elasticemail.com";      // sets GMAIL as the SMTP server
            $mail->Port       = 2525;                   // set the SMTP port

            $mail->Username   = "onyishifrancisss2v@gmail.com";  // GMAIL username
            $mail->Password   = "47b49496-17b2-4eee-9888-c7b4a60cd3f4";            // GMAIL password

//$mail->From       = "replyto@yourdomain.com";
//$mail->FromName   = "Webmaster";


            $mail->setFrom("alb@ofcwork.ml" , "devl", false);
            $mail->Subject    = "Verify";
            $mail->AltBody    = "This is the body when user views in plain text format"; //Text Body
            $mail->WordWrap   = 50; // set word wrap

            $mail->Body="
            hello $this->fname,<br>
            Thank you for signing up!<br>
            Please click on this link to activate your account:<br>
            http://localhost/questions/verify.php?email=$this->email&hash=$this->hash";

            $mail->AddReplyTo("replyto@yourdomain.com","info");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

            $mail->AddAddress("$this->email","$this->fname");

            $mail->IsHTML(true); // send as HTML

            if(!$mail->Send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
                $_SESSION['message']="there was a problem in the creation of account";
            } else {
                header("location:success.php");
            }
        }
    }
}

$obj=new Get();
$obj->construct();
//$obj->free2();
$obj->check1();
$obj->mail();
//$obj->upload();


?>