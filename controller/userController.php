<?php
/**
* @file      userController.php
* @brief     This file is the controller managing all actions that concern user
* @author    Created by Antoine Roulin
* @version   14.03.2023
*/

/**
 * @brief This function is designed to check if user : fill correctly all field, email entered by user doesn't match with a email user already registered and if all is ok it register the new member in the database
 * @param $registerData
 * @return void
 */
function registerUser($registerData) : void
{
        try {
            if (isset($registerData['userEmail']) &&
                isset($registerData['userUsername']) &&
                isset($registerData['userPassword']) &&
                isset($registerData['userPasswordVerify'])
            ){
                require_once dirname(__FILE__) . "/../model/userService.php";
                register($registerData);
                $_SESSION['email'] = $registerData['userEmail'];
                require_once (dirname(__FILE__)."/../view/home.php");
            } else {
                require_once (dirname(__FILE__)."/../view/register.php");
            }
        }
        catch (RegisterException $e){
            $error = nl2br(
                "<b>Register problem, please follow this rules :</b>\n
                Email need to be : 319 character or shorter\n
                Username need to be : 50 character or shorter \n
                Password need to be : 255 character or shorter \n
                Password Verify need to be : 255 character or shorter \n");
            require_once (dirname(__FILE__)."/../view/register.php");
        }
        catch (SystemNotAvailable $e){
            $error = "System not available";
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
    try {
        if(isset($loginData['userEmail']) && isset($loginData['userPassword'])){
            require_once dirname(__FILE__) . "/../model/userService.php";
            login($loginData);
            $_SESSION['email'] = $loginData['userEmail'];
            require_once (dirname(__FILE__)."/../view/home.php");
        } else {
            require_once (dirname(__FILE__)."/../view/login.php");
        }
    }
    catch (SystemNotAvailable $e){
        $error = "System not available";
        require_once (dirname(__FILE__)."/../view/login.php");
    }
    catch (MemberDoesntExist $e){
        $error = "Member doesn't exist";
        require_once (dirname(__FILE__)."/../view/login.php");
    }
    catch (WrongLoginCredentials $e){
        $error = "Wrong email or password";
        require_once (dirname(__FILE__)."/../view/login.php");
    }
}

/**
 * @brief Logout the user connected
 * @return void
 */
function logoutUser(): void
{
    $_SESSION = null;
    session_destroy();
    require_once (dirname(__FILE__)."/../view/home.php");
}


