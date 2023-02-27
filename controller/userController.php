<?php
/**
* @file      navigation.php
* @brief     This file is the controller managing all actions that concern user
* @author    Created by Antoine Roulin
* @version   27.02.2023
*/

/**
 * @brief This function is designed to redirect the user on the register page and check if user : fill correctly all field, email entered by user doesn't match with a email user already registered and if all is ok it register the new member in the database
 * @param $registerData
 * @return void
 */
function register($registerData){
    try {
        require_once dirname(__FILE__)."/../model/userModel.php";
        checkData($registerData); //Call this function to check if data entered in the form by user respect all constraint of the database and if all field requiered is fill of data.
        ifMemberExist($registerData['userEmail']); //Call this function to check if the email entered by the user already match with a user registered in the database.
        registering($registerData); //Call this function to register the new member
        require_once dirname(__FILE__)."/../controller/navigation.php";
        home(); //Call this function to get back to homepage
    }
    catch (databaseException){
        $error = 'An error has occured. Please try later';
        require_once (dirname(__FILE__)."/../view/register.php");
    }
    catch (passwordNotMatchException){
        $error = 'The two passwords are not matching';
        require_once (dirname(__FILE__)."/../view/register.php");
    }
    catch (notFullFillException){
        $error = 'You have not filled all requiered field or not correctly filled';
        require_once (dirname(__FILE__)."/../view/register.php");
    }
    catch (registeredException){
        $error = 'You already have an account';
        require_once (dirname(__FILE__)."/../view/register.php");
    }
}

?>