<?php
/**
 * @file      userModel.php
 * @brief     This file is the model is used to do all actions
 * @throws memberAlreadyExist
 * @throws twoPasswordDontMatch
 * @throws notMeetDatabaseRequirement|databaseException
 * @version   01.03.2023
 * @author    Created by Antoine Roulin
 */

function register($registerData) : void
{
    $checkDataResult = checkData($registerData);//Call this function to check if data entered in the form by user respect all constraint of the database and store the result of the function in the variable $checkDataResult.
    $checkPasswordMatchResult = checkPasswordMatching($registerData); //Call this function to check if two password entered by user is the same and store the result of the function in the variable $checkPasswordMatchResult.a
    $checkDoesMemberExistResult = doesMemberExist($registerData['userEmail']); //Call this function to check if the email entered by the user already match with a user registered in the database.
    if ($checkDataResult){
        if ($checkPasswordMatchResult){
            if (!$checkDoesMemberExistResult){
                addUser($registerData); //Call this function to register the new member
            } else {
                throw new memberAlreadyExist("A member with the same email already exist");
            }
        } else {
            throw new twoPasswordDontMatch("The two passwords you entered are not the same");
        }
    } else {
        throw new notMeetDatabaseRequirement("The information you have entered does not meet the requested conditions");
    }
}

/**
 * @brief Check if data entered in the form by user respect all constraint of the database and if all field requiered is fill of data.
 * @param $dataToCheck
 * @throws passwordNotMatchException : Meaning two password given by user is not matching.
 * @throws NotFullFillException : Meaning all field requiered in the form are not fill of information.
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

function checkPasswordMatching($passwordToCheckMatching) : bool
{
    if ($passwordToCheckMatching['userPassword'] == $passwordToCheckMatching['userPasswordVerify']) {
        return true;
    } else {
        return false;
    }
}

/**
 * @brief This function is designed to check if the email entered by the user already match with a user registered in the database.
 * @param $email
 * @throws databaseException : Meaning an error comming from the database connexion.
 * @throws registeredException : Meaning a user already exists with this email address.
 */
function doesMemberExist($email) : bool
{
    require_once dirname(__FILE__)."/dbConnector.php";
    $query = "SELECT email_address FROM accounts WHERE email_address ='" . $email . "';";
    $queryResult = executeQueryReturn($query);
    if(count($queryResult) == 1){
        return true;
    }
    return false;
}

/**
 * @brief This function is designed to register a new user in the database.
 * @param $registerData
 * @throws databaseException : Meaning an error from the database connexion.
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
