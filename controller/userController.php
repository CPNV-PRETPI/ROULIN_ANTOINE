<?php
/**
* @file      navigation.php
* @brief     This file is the controller managing all actions that concern user
* @author    Created by Antoine Roulin
* @version   05.03.2023
*/

/**
 * @brief This function is designed to¨ check if user : fill correctly all field, email entered by user doesn't match with a email user already registered and if all is ok it register the new member in the database
 * @param $registerData
 * @return void
 */
function registerUser($registerData) : void
{
    if(
        isset($registerData['userUsername']) &&
        isset($registerData['userPassword']) &&
        isset($registerData['userPasswordVerify']) &&
        isset($registerData['userEmail'])
    ){
        try {
            require_once dirname(__FILE__)."/../model/userModel.php";
            register($registerData);
            require_once (dirname(__FILE__)."/../view/home.php");
        }
        catch (notMeetDatabaseRequirement|twoPasswordDontMatch|memberAlreadyExist|databaseException $e){
            $error = $e->getMessage(); //Set the variable $error by the message contained in the thrown exception to display after the content of $error in the view
            require_once (dirname(__FILE__)."/../view/register.php");
        }
    } else {
        $error = "One of the fields is empty, please fill it in"; //Set the variable $error a custom message if the form was not filled in completly
        require_once (dirname(__FILE__)."/../view/register.php");
    }
}

/**
 * @brief This function is designed to login the user if : the email and password given by the user match with a user already registered
 * @param $loginData
 * @return void
 */
function loginUser($loginData) : void
{
    if(isset($loginData['userEmail']) && isset($loginData['userPassword'])){
        try {
            require_once dirname(__FILE__)."/../model/userModel.php";
            login($loginData);
            require_once (dirname(__FILE__)."/../view/home.php");
        }
        catch (databaseException|wrongLoginCredentials|memberDoesntExist $e){
            $error = $e->getMessage(); //Set the variable $error by the message contained in the thrown exception to display after the content of $error in the view
            require_once (dirname(__FILE__)."/../view/login.php");
        }
    } else {
        $error = "One of the fields is empty, please fill it in"; //Set the variable $error a custom message if the form was not filled in completly
        require_once (dirname(__FILE__)."/../view/register.php");
    }
}

function logoutUser(){
    require_once dirname(__FILE__)."/../model/userModel.php";
    logout();
    require_once (dirname(__FILE__)."/../view/home.php");
}


