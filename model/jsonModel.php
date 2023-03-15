<?php
/**
 * @file      jsonModel.php
 * @brief     This file is the model is used to read and return the content of a json
 * @author    Created by Antoine Roulin
 * @version   01.03.2023
 */

/**
 * @brief This function is designed to open the Json file in read mode,
 * read it and return the content decoded
 * @param $fileName
 * @return mixed
 * @throws jsonFileException
 */
function readJson($fileName): mixed
{
    if (file_exists($fileName)) {
        $file = fopen($fileName, "r");
        if (!($file)) {
            throw new jsonFileException();
        } else {
            $fileContent = fread($file, filesize($fileName));
            return json_decode($fileContent);
        }
    }
    else{
        throw new JsonFileException();
    }
}

class JsonFileException extends Exception{}
