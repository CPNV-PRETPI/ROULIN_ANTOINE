<?php
/**
 * @file      userModel.php
 * @brief     This file is the model is used to do all actions
 * @author    Created by Antoine Roulin
 * @version   24.02.2023
 */

/**
 * @brief Check if data entered in the form by user respect all constraint of the database and if all field requiered is fill of data.
 * @param $dataToCheck
 * @throws passwordNotMatchException : Meaning two password given by user is not matching.
 * @throws NotFullFillException : Meaning all field requiered in the form are not fill of information.
 */
function checkData($dataToCheck){
    //Checking if all field are filled.
    if(
        isset($dataToCheck['userUsername']) &&
        isset($dataToCheck['userPassword']) &&
        isset($dataToCheck['userPasswordVerify']) &&
        isset($dataToCheck['userEmail'])
    ) {
        //Check if all field respect database constraint.
        if (
            strlen($dataToCheck['userUsername']) <= 50 &&
            strlen($dataToCheck['userPassword']) <= 256 &&
            strlen($dataToCheck['userPasswordVerify']) <= 256 &&
            strlen($dataToCheck['userEmail']) <= 319
        ) {
            if ($dataToCheck['userPassword'] == $dataToCheck['userPasswordVerify']) {
                return true;
            } else {
                throw new passwordNotMatchException();
            }
        }
    }
    else{
        throw new notFullFillException();
    }
}

/**
 * @brief This function is designed to check if the email entered by the user already match with a user registered in the database.
 * @param $email
 * @throws databaseException : Meaning an error comming from the database connexion.
 * @throws registeredException : Meaning a user already exists with this email address.
 */
function ifMemberExist($email)
{
    require_once dirname(__FILE__)."/dbConnector.php";
    try {
        $query = "SELECT email_address FROM accounts WHERE email_address ='" . $email . "';";
        $queryResult = executeQueryReturn($query);
        if(count($queryResult) != 0){
            throw new registeredException();
        }
    }
    catch (databaseException){
        throw new databaseException();
    }
}

/**
 * @brief This function is designed to register a new user in the database.
 * @param $registerData
 * @throws databaseException : Meaning an error from the database connexion.
 */
function registering($registerData){
    require_once dirname(__FILE__)."/dbConnector.php";
    try {
        $passwordHash = password_hash($registerData['userPassword'], PASSWORD_DEFAULT);
        $query = "INSERT INTO accounts VALUES (NULL,'" . $registerData['userEmail'] . "','" . $registerData['userUsername'] . "','" . $passwordHash . "');";
        $queryResult = executeQuery($query);
    }
    catch (databaseException){
        throw new databaseException();
    }
}

class registeredException extends Exception{}
class passwordNotMatchException extends Exception{}
class notFullFillException extends Exception{}