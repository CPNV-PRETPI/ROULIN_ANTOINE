<?php
/**
* @file      navigation.php
* @brief     This file is the controller managing all actions that concern user
* @author    Created by Antoine Roulin
* @version   01.03.2023
*/

/**
 * @brief This function is designed to redirect the user on the register page and check if user : fill correctly all field, email entered by user doesn't match with a email user already registered and if all is ok it register the new member in the database
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
            $_SESSION['userUsername'] = $registerData['userUsername'];
            require_once (dirname(__FILE__)."/../controller/navigation.php");
            home(); //Call this function to get back to homepage
        }
        catch (notMeetDatabaseRequirement|twoPasswordDontMatch|memberAlreadyExist|databaseException $e){
            $error = $e->getMessage(); //Set the variable $error by the message contained inthe thrown exception to display after the content of $error in the view
            require_once (dirname(__FILE__)."/../controller/navigation.php");
            displayRegister(); //Call this function to get back to register page
        }
    } else {
        $error = "One of the fields is empty, please fill it in"; //Set the variable $error a custom message if the form was not filled in completly
        require_once (dirname(__FILE__)."/../controller/navigation.php");
        displayRegister(); //Call this function to get back to register page
    }
}
?>