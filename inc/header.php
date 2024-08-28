<?php

use OnlineShoping\Session\Session;
use OnlineShoping\Users\User;

require_once './classes/Session.php';
require_once './classes/User.php';
$session = new Session();
$id = $session->get('userId');
$exist = $session->exist('userId');
$user = new User();
$user = $user->getUser($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Online Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">All Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Add.php">Add Product</a>
                    </li>


                </ul>
                <ul class="form-inline my-2 my-lg-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <?php 
                            
                                if($exist){
                                    echo $user['name'];
                                }else{
                                    echo 'User Name';
                                }
                            
                            ?>
                        </button>
                        <div class="dropdown-menu">
                            <?php if($exist):?>
                                <a class="dropdown-item" href="./handlers/handleUser/logout.php">Logout</a>
                            <?php else:?>
                            <a class="dropdown-item" href="./register.php">Register</a>
                            <a class="dropdown-item" href="./login.php">Login</a>
                            <!-- <a class="dropdown-item" href="#"></a> -->
                            <?php endif?>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </nav>