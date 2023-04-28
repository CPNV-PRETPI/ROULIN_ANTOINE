<?php
/**
 * @file      userService.php
 * @brief     This file is the model is used to do all actions
 * @author    Created by Antoine Roulin
 * @version   14.03.2023
 */
include dirname(__FILE__) . "/../entity/User.php";
/**
 * @brief This function will go through all verifications process and
 * if all conditions are respected it will register the user using
 * addUser function.
 * @param $registerData
 * @return User
 * @throws RegisterException
 * @throws SystemNotAvailable
 */
function register($registerData) : void
{
    try {
        require_once dirname(__FILE__) . "/../data/dbConnector.php";
        checkRegister($registerData);
        $user = new User($registerData['userEmail'], $registerData['userPassword']);
        addUser($user);
    }
    catch (PDOException|JsonFileException){
        throw new SystemNotAvailable();
    }
}

/**
 * @brief Check if credentials given by user match with a user in database and if password given match with the password
 * in database of the user given and if not, it will throw this UserDoesntExist.
 * @param $loginData
 * @return User
 * @throws MemberDoesntExist
 * @throws SystemNotAvailable
 * @throws WrongLoginCredentials
 */
function login($loginData) : void
{
    try {
        require_once dirname(__FILE__) . "/../data/dbConnector.php";
        $query = "SELECT email, password FROM accounts WHERE email ='" . $loginData['userEmail'] . "';";
        $queryResult = executeQuery($query);
        if ($queryResult == null) {
            throw new MemberDoesntExist();
        }
        if (!password_verify($loginData['userPassword'], $queryResult[0]['password'])) {
            throw new WrongLoginCredentials();
        }
    }
    catch(PDOException|JsonFileException){
        throw new SystemNotAvailable();
    }
}

/**
 * @brief This function is designed to do all check and throw exceptions if check doesn't pass.
 * @param $registerData
 * @return void
 * @throws RegisterException
 * @throws jsonFileException
 */
function checkRegister($registerData) : void
{
    if (!checkData($registerData)){
        throw new RegisterException();
    }
    if (!checkPasswordMatching($registerData)){
        throw new RegisterException();
    }
    if (doesMemberExist($registerData['userEmail'])){
        throw new RegisterException();
    }
}

/**
 * @brief Check if data entered in the form by user respect all constraint of the database and if all field required is
 * fill of data.
 * @param $dataToCheck
 * @return bool
 */
function checkData($dataToCheck) : bool
{
    if (
        strlen($dataToCheck['userPassword']) <= 256 &&
        strlen($dataToCheck['userPasswordVerify']) <= 256 &&
        strlen($dataToCheck['userEmail']) <= 319
    ){
        return true;
    }
    return false;
}

/**
 * @brief This function will check if both password entered by the user is matching (same).
 * @param $passwordToCheckMatching
 * @return bool
 */
function checkPasswordMatching($passwordToCheckMatching) : bool
{
    if ($passwordToCheckMatching['userPassword'] == $passwordToCheckMatching['userPasswordVerify']) {
        return true;
    }
    return false;
}

/**
 * @brief This function is designed to check if the email entered by the user already match with an email of a user
 * registered in the database.
 * @param $email
 * @return bool
 * @throws jsonFileException
 */
function doesMemberExist($email) : bool
{
    require_once dirname(__FILE__) . "/../data/dbConnector.php";
    $query = "SELECT email FROM accounts WHERE email ='" . $email . "';";
    $queryResult = executeQuery($query);
    if($queryResult != null){
        return true;
    }
    return false;
}

/**
 * @brief This function is designed to add a new user in the database.
 * @param $user
 * @return void
 * @throws jsonFileException
 */
function addUser($user) : void
{
    require_once dirname(__FILE__) . "/../data/dbConnector.php";
    $passwordHash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
    $query = "
        INSERT INTO accounts
        VALUES (
            NULL,
            '" . $user->getEmail() . "',
            '" . $passwordHash . "'
        );
    ";
    executeQuery($query);
}
class UserException extends Exception{}
class SystemNotAvailable extends UserException{}
class RegisterException extends UserException{}
class WrongLoginCredentials extends UserException{}
class MemberDoesntExist extends UserException{}

