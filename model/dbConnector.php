<?php
/**
 * @file      dbConnector.php
 * @brief     This file is the model is used to connect to database and do request to the database
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

/**
 * @brief This function is designed to open and return a database connection
 * @return PDO
 * @throws databaseException
 */
function openDBConnexion() : PDO
{
    $tempDBConnexion = null;

    require_once dirname(__FILE__)."/jsonModel.php";
    try{
        $credentials = readJson(dirname(__FILE__)."/dbCredentials.json"); //Attribute the return of readJson to the variable $credentials
        $dsn = $credentials->sqlDriver. ":host=". $credentials->hostName . ";dbname=".
            $credentials->dbName.";port=".$credentials->port.";charset=".$credentials->charset;
        $tempDBConnexion = new PDO($dsn, $credentials->userName, $credentials->userPwd);
    }
    catch(jsonFileException | PDOException){
        throw new databaseException("An error has occurred, please try again later");
    }
    return $tempDBConnexion;
}

/**
 * @brief This function is designed to execute a select query received as parameter
 * @param $query : the query to execute
 * @return array|null
 * @throws databaseException
 * @link https://php.net/manual/en/pdo.prepare.php
 */
function executeQueryReturn($query) : array|null
{
    $queryResult = null;
    $dbConnexion = openDBConnexion();//Opens DB connection
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query); //Prepare the query
        $statement->execute(); //Query execution
        $queryResult = $statement->fetchAll();
    }
    else{
        throw new databaseException("An error has occurred, please try again later");
    }
    $dbConnexion = null; //Closing connection to the DB
    return $queryResult;
}

/**
 * @brief This function is designed to execute an insert query received as parameter
 * @param $query
 * @return void
 * @throws databaseException
 */
function executeQuery($query) : void
{
    $dbConnexion = openDBConnexion(); //Opens DB connection
    $result = false;
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query); //Prepare the query
        $result = $statement->execute(); //Query execution
        if(!$result){ //If $result is false that tell that the query has not work
            throw new databaseException("An error has occurred, please try again later");
        }
    }
    else{
        throw new databaseException("An error has occurred, please try again later");
    }
    $dbConnexion = null; //Closing connection to the DB
}

class DatabaseException extends Exception{} //Create a custom class databaseException that extends the main class Exception