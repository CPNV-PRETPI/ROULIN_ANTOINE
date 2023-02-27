<?php
/**
 * @file      dbConnector.php
 * @brief     This file is the model is used to connect to database and do request to the database
 * @author    Created by Antoine Roulin
 * @version   10.02.2023
 */

/**
 * @return PDO
 * @throws databaseException
 */
function openDBConnexion(){
    $tempDBConnexion = null;

    require_once dirname(__FILE__)."/jsonModel.php";
    try{
        $credentials = readJson(dirname(__FILE__)."/dbCredentials.json"); //Attribute the return of readJson to the variable $credentials
        $dsn = $credentials->sqlDriver. ":host=". $credentials->hostName . ";dbname=".
            $credentials->dbName.";port=".$credentials->port.";charset=".$credentials->charset;
        $tempDBConnexion = new PDO($dsn, $credentials->userName, $credentials->userPwd);
    }
    catch(jsonFileException | PDOException){
        throw new databaseException();
    }
    return $tempDBConnexion;
}

/**
 * @brief This function is designed to execute a select query received as parameter
 * @param $query : the query to execute
 * @return array|null
 * @link https://php.net/manual/en/pdo.prepare.php
 */
function executeQueryReturn($query){
    $queryResult = null;
    $dbConnexion = openDBConnexion();//Opens DB connection
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query); //Prepare the query
        $statement->execute(); //Query execution
        $queryResult = $statement->fetchAll();
    }
    else{
        throw new databaseException();
    }
    $dbConnexion = null; //Closing connection to the DB
    return $queryResult;
}

/**
 * @brief This function is designed to execute an insert query received as parameter
 * @param $query
 * @throws databaseException : This exception is thrown if something went wrong with the query execution
 */
function executeQuery($query){
    $dbConnexion = openDBConnexion(); //Opens DB connection
    $result = false;
    if ($dbConnexion != null){
        $statement = $dbConnexion->prepare($query); //Prepare the query
        $result = $statement->execute(); //Query execution
        if($result == false){
            throw new databaseException();
        }
    }
    else{
        throw new databaseException();
    }
    $dbConnexion = null; //Closing connection to the DB

}

class databaseException extends Exception{} //Create a custom class databaseException that extends the main class Exception