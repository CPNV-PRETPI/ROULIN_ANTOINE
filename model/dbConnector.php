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
 * @throws DatabaseException
 */
function openDBConnexion() : PDO
{
    $tempDBConnexion = null;

    require_once dirname(__FILE__)."/jsonModel.php";
    try{
        $credentials = readJson(dirname(__FILE__)."/dbCredentials.json");
        $dsn = $credentials->sqlDriver. ":host=". $credentials->hostName . ";dbname=".
            $credentials->dbName.";port=".$credentials->port.";charset=".$credentials->charset;
        $tempDBConnexion = new PDO($dsn, $credentials->userName, $credentials->userPwd);
    }
    catch(jsonFileException | PDOException){
        throw new DatabaseException("An error has occurred, please try again later");
    }
    return $tempDBConnexion;
}

/**
 * @brief This function is designed to execute a select query received as parameter
 * @param $query : the query to execute
 * @return array|null
 * @throws DatabaseException
 * @link https://php.net/manual/en/pdo.prepare.php
 */
function executeQuery($query) : array|null
{
    $queryResult = null;
    $dbConnexion = openDBConnexion();
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query);
        $statement->execute();
        $queryResult = $statement->fetchAll();
    }
    else{
        throw new DatabaseException("An error has occurred, please try again later");
    }
    $dbConnexion = null;
    return $queryResult;
}

/**
 * @brief This function is designed to execute an insert query received as parameter
 * @param $query
 * @return void
 * @throws DatabaseException
 */
/*function executeQuery($query) : void
{
    $dbConnexion = openDBConnexion();
    $result = false;
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query);
        $result = $statement->execute();
        if(!$result){
            throw new DatabaseException("An error has occurred, please try again later");
        }
    }
    else{
        throw new DatabaseException("An error has occurred, please try again later");
    }
    $dbConnexion = null;
}*/

class DatabaseException extends Exception{}