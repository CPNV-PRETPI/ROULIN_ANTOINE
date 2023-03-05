<?php
/**
 * @file      userModel.php
 * @brief     This file is the model is used to do all actions
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

/**
 * @brief This function will go through all verifications proccess and if all conditions is respected it will register the user using addUser function
 * @param $registerData
 * @return void
 * @throws databaseException
 * @throws memberAlreadyExist
 * @throws notMeetDatabaseRequirement
 * @throws twoPasswordDontMatch
 */
function register($registerData) : void
{
    $checkDataResult = checkData($registerData);//Call this function to check if data entered in the form by user respect all constraint of the database and store the result of the function in the variable $checkDataResult.
    $checkPasswordMatchResult = checkPasswordMatching($registerData); //Call this function to check if two password entered by user is the same and store the result of the function in the variable $checkPasswordMatchResult.
    $checkDoesMemberExistResult = doesMemberExist($registerData['userEmail']); //Call this function to check if the email entered by the user already match with a user registered in the database.
    if ($checkDataResult){ // If the result of the function checkData is true it will do the next check inside of the condition
        if ($checkPasswordMatchResult){ // If the result of the function checkPasswordMatching is true it will do the next check inside of the condition
            if (!$checkDoesMemberExistResult){ // If the result of the function doesMemberExist is false (user doesn't already exist) it will do the addUser function that is inside of the condition
                addUser($registerData); //Call this function to add the new member
                $_SESSION['username'] = $registerData['userUsername']; //Set in the session the username of the member that just register to login him, this will be the variable I check everytime I need to know if the user is logged in
            } else {
                throw new memberAlreadyExist("This account already exist");
            }
        } else {
            throw new twoPasswordDontMatch("The two passwords you entered are not the same");
        }
    } else {
        throw new notMeetDatabaseRequirement("The information you have entered does not meet the requested conditions");
    }
}

/**
 * @brief Check if credentials given by user match with a user in database and if not, it will throw thiUserDoesntExist
 * @param $loginData
 * @return void
 * @throws databaseException
 * @throws wrongLoginCredentials
 * @throws memberDoesntExist
 */
function login($loginData) : void
{
    require_once dirname(__FILE__)."/dbConnector.php";
    $query = "SELECT * FROM accounts WHERE email ='" . $loginData['userEmail'] . "';";
    $loginQueryResult = executeQueryReturn($query);
    if (isset($loginQueryResult[0]['password'])){
        if (password_verify($loginData['userPassword'], $loginQueryResult[0]['password'])){
            $_SESSION['username'] = $loginQueryResult[0]['username'];
        } else {
            throw new wrongLoginCredentials("Wrong email or password");
        }
    } else {
        throw new memberDoesntExist("This account doesn't exist");
    }
}

function logout() : void
{
    $_SESSION = null;
    session_destroy();
}

/**
 * @brief Check if data entered in the form by user respect all constraint of the database and if all field requiered is fill of data.
 * @param $dataToCheck
 * @return bool
 */
function checkData($dataToCheck) : bool
{
    //Check if all field respect database constraint.
    if (
        strlen($dataToCheck['userUsername']) <= 50 &&
        strlen($dataToCheck['userPassword']) <= 256 &&
        strlen($dataToCheck['userPasswordVerify']) <= 256 &&
        strlen($dataToCheck['userEmail']) <= 319
    ) {
        return true;
    } else{
        return false;
    }
}

/**
 * @brief This function will check if both password entered by the user is matching (same)
 * @param $passwordToCheckMatching
 * @return bool
 */
function checkPasswordMatching($passwordToCheckMatching) : bool
{
    if ($passwordToCheckMatching['userPassword'] == $passwordToCheckMatching['userPasswordVerify']) {
        return true;
    } else {
        return false;
    }
}

/**
 * @brief This function is designed to check if the email entered by the user already match with an email of a user registered in the database.
 * @param $email
 * @return bool
 * @throws databaseException
 */
function doesMemberExist($email) : bool
{
    require_once dirname(__FILE__)."/dbConnector.php";
    $query = "SELECT email FROM accounts WHERE email ='" . $email . "';";
    $queryResult = executeQueryReturn($query);
    if(count($queryResult) == 1){
        return true;
    }
    return false;
}

/**
 * @brief This function is designed to add a new user in the database.
 * @param $registerData
 * @return void
 * @throws databaseException
 */
function addUser($registerData) : void
{
    require_once dirname(__FILE__)."/dbConnector.php";
    $passwordHash = password_hash($registerData['userPassword'], PASSWORD_DEFAULT);
    $query = "INSERT INTO accounts VALUES (NULL,'" . $registerData['userEmail'] . "','" . $registerData['userUsername'] . "','" . $passwordHash . "');";
    executeQuery($query);
}

class notMeetDatabaseRequirement extends Exception{}
class twoPasswordDontMatch extends Exception{}
class memberAlreadyExist extends Exception{}
class wrongLoginCredentials extends Exception{}
class memberDoesntExist extends Exception{}

