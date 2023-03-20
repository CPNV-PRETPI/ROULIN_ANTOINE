<?php
/**
 * @file      index.php
 * @brief     This file is the rooter managing the link with controllers.
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

require "controller/userController.php";
require "controller/navigation.php";

session_start();

if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch ($action){
        case "home":
            home();
            break;
        case "register":
            registerUser($_POST);
            break;
        case "login":
            loginUser($_POST);
            break;
        case "logout":
            logoutUser();
            break;
        default:
            home();
    }
}
else{
    home();
}


