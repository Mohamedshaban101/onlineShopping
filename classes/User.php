<?php 

namespace OnlineShoping\Users;
use OnlineShoping\Databases\Database;
use OnlineShoping\Session\Session;
use OnlineShoping\PasswordHash\PasswordHash;

require_once __DIR__.'/Session.php';
require_once __DIR__.'/Database.php';
require_once __DIR__.'/PasswordHash.php';
class User{
    private $con;

    public function __construct()
    {
        $database = new Database();
        $this->con = $database->getConnection();
    }

    public function register($name , $email , $password , $phone , $address){
        $passwordHash = new PasswordHash();
        $passwordHash = $passwordHash->setPassword($password);
        $sql = "INSERT INTO `users` (`name`,`email` ,`password` , `phone`,`address`) VALUES (:name , :email , '$passwordHash' , :phone , :address)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':name' , $name);
        $stmt->bindParam(':email' , $email);
        $stmt->bindParam(':phone' , $phone);
        $stmt->bindParam(':address' , $address);
        if($stmt->execute()){
            // $session = new Session();
            // $session->set('successAdd' , 'registeration successfully');
            header('location:../../login.php');
            die();
        }else{
            $session = new Session();
            $session->set('errorAdd' , 'registeration failed');
            header('location:../../register.php');
            die();
        }
    }

    public function login($email , $password){
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $user = $stmt->fetch();
            $passwordHash = new PasswordHash();
            if($passwordHash->verifyPassword($password , $user['password'])){
                $session = new Session();
                $session->set('userId' , $user['id']);
                header('location:../../index.php');
                die();
            }else{
                $session = new Session();
                $session->set('errorLogin' , 'email or password not correct');
                header('location:../../login.php');
                die();
            }
        }else{
            header('location:../../register.php');
            die();
        }
        // echo $email;
        // echo $password;
    }

    public function logout(){
        $session = new Session();
        $session->remove('userId');
    }
    public function getUser($id){
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id',$id);
        if($stmt->execute()){
            $user = $stmt->fetch();
        }
        return $user;
    }
}



?>