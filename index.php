<?php
/**
 * @file      index.php
 * @brief     This file is the rooter managing the link with controllers.
 * @author    Created by Antoine Roulin
 * @version   01.03.2023
 */

require "controller/userController.php";
require "controller/navigation.php";

if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch ($action){
        case "home":
            home();
            break;
        case "displayRegister":
            displayRegister();
            break;
        case "register":
            registerUser($_POST);
            break;
    }
}
else{
    home();
}


