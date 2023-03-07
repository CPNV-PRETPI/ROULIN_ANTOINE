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
        try {
            require_once dirname(__FILE__) . "/../model/userService.php";
            register($registerData);
            $_SESSION['username'] = $registerData['userUsername']; //Set in the session the username of the member that just register to login him, this will be the variable I check everytime I need to know if the user is logged in
            require_once (dirname(__FILE__)."/../view/home.php");
        }
        catch (NotMeetDatabaseRequirement){
            $error = "You have enter information that is too long";
            require_once (dirname(__FILE__)."/../view/register.php");
        }
        catch (TwoPasswordDontMatch){
            $error = "Two password given don't match";
            require_once (dirname(__FILE__)."/../view/register.php");
        }
        catch (MemberAlreadyExist){
            $error = "This email is already taken. Try another email.";
            require_once (dirname(__FILE__)."/../view/register.php");
        }
        catch (DatabaseException){
            $error = "An error occurred, please try later";
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
            require_once dirname(__FILE__) . "/../model/userService.php";
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

function logoutUser(): void
{
    require_once dirname(__FILE__) . "/../model/userService.php";
    logout();
    require_once (dirname(__FILE__)."/../view/home.php");
}


