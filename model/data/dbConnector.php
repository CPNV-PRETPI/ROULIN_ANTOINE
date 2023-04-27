<?php
/**
 * @file      dbConnector.php
 * @brief     This file is the model is used to connect to database and do request to the database
 * @author    Created by Antoine Roulin
 * @version   14.03.2023
 */

/**
 * @brief This function is designed to open and return a database connection
 * @return PDO
 * @throws jsonFileException
 */
function openDBConnexion() : PDO
{
    require_once dirname(__FILE__) . "/../jsonModel.php";

    $credentials = readJson(dirname(__FILE__) . "/../dbCredentials.json");

    $dsn = $credentials->sqlDriver. ":host=". $credentials->hostName . ";dbname=".
        $credentials->dbName.";port=".$credentials->port.";charset=".$credentials->charset;

    return new PDO($dsn, $credentials->userName, $credentials->userPwd);
}

/**
 * @brief This function is designed to execute a select query received as parameter
 * @param $query
 * @return array|null
 * @throws jsonFileException
 */
function executeQuery($query) : array|null
{
    $dbConnexion = openDBConnexion();

    $statement = $dbConnexion->prepare($query);
    $statement->execute();
    $queryResult = $statement->fetchAll();

    $dbConnexion = null;
    return $queryResult;
}