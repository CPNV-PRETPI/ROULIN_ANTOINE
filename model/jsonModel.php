<?php
/**
 * @file      jsonModel.php
 * @brief     This file is the model is used to read and return the content of a json
 * @author    Created by Antoine Roulin
 * @version   01.03.2023
 */

/**
 * @brief This function is designed to open the Json file in read mode, read it and return the content decoded
 * @param $fileName
 * @return mixed
 * @throws jsonFileException
 */
function readJson($fileName){
    if (file_exists($fileName)) { //Check if file exist
        $file = fopen($fileName, "r"); //Create a pointer on the file of $fileName in read mode and attribute it to $file variable
        if (!($file)) { //Checking if the file exists
            throw new jsonFileException(); //Throw new exception of type jsonFileException
        } else {
            $fileContent = fread($file, filesize($fileName)); //Gets the content of the file
            return json_decode($fileContent); //Decode the content from Json ton php objects
        }
    }
    else{
        throw new jsonFileException(); //Throw new exception of type jsonFileException
    }
}

class jsonFileException extends Exception{} //Create a custom class jsonFileException that extends the main class Exception
