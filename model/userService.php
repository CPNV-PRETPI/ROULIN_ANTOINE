<?php
/**
 * @file      userController.php
 * @brief     This file is the model is used to do all actions
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

/**
 * @brief This function will go through all verifications proccess and if all conditions is respected it will register the user using addUser function
 * @param $registerData
 * @return void
 * @throws DatabaseException
 * @throws MemberAlreadyExist
 * @throws NotMeetDatabaseRequirement
 * @throws TwoPasswordDontMatch
 */
function register($registerData) : void
{
    checkRegister($registerData);
    addUser($registerData);
}

/**
 * @brief Check if credentials given by user match with a user in database and if not, it will throw thiUserDoesntExist
 * @param $loginData
 * @return void
 * @throws WrongLoginCredentials
 * @throws MemberDoesntExist
 * @throws SystemNotAvailable
 * @throws DatabaseException
 */
function login($loginData) : void
{
    try {
        require_once dirname(__FILE__) . "/dbConnector.php";
        $query = "SELECT password FROM accounts WHERE email ='" . $loginData['userEmail'] . "';";
        $queryResult = executeQuery($query);
        if ($queryResult == null) {
            throw new MemberDoesntExist();
        }
        if (!password_verify($loginData['userPassword'], $queryResult[0]['password'])) {
            throw new WrongLoginCredentials();
        }
    }
    catch(PDOException $e){
        throw new SystemNotAvailable();
    }
}

/**
 * @brief This function is designed to do all check and throw exceptions if check doesn't pass
 * @param $registerData
 * @return void
 * @throws DatabaseException
 * @throws MemberAlreadyExist
 * @throws NotMeetDatabaseRequirement
 * @throws TwoPasswordDontMatch
 */
function checkRegister($registerData) : void
{
    if (!checkData($registerData)){
        throw new NotMeetDatabaseRequirement();
    }
    if (!checkPasswordMatching($registerData)){
        throw new TwoPasswordDontMatch();
    }
    if (doesMemberExist($registerData['userEmail'])){
        throw new MemberAlreadyExist();
    }
}

/**
 * @brief Check if data entered in the form by user respect all constraint of the database and if all field requiered is fill of data.
 * @param $dataToCheck
 * @return bool
 */
function checkData($dataToCheck) : bool
{
    if (
        strlen($dataToCheck['userUsername']) <= 50 &&
        strlen($dataToCheck['userPassword']) <= 256 &&
        strlen($dataToCheck['userPasswordVerify']) <= 256 &&
        strlen($dataToCheck['userEmail']) <= 319
    ){
        return true;
    }
    return false;
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
 * @throws DatabaseException
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
 * @throws DatabaseException
 */
function addUser($registerData) : void
{
    require_once dirname(__FILE__)."/dbConnector.php";
    $passwordHash = password_hash($registerData['userPassword'], PASSWORD_DEFAULT);
    $query = "INSERT INTO accounts VALUES (NULL,'" . $registerData['userEmail'] . "','" . $registerData['userUsername'] . "','" . $passwordHash . "');";
    executeQuery($query);
}
class UserException extends Exception{}
class SystemNotAvailable extends UserException{}
class NotMeetDatabaseRequirement extends UserException{}
class TwoPasswordDontMatch extends UserException{}
class MemberAlreadyExist extends UserException{}
class WrongLoginCredentials extends UserException{}
class MemberDoesntExist extends UserException{}

