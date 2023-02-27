<?php
/**
 * @file      navigation.php
 * @brief     This file is the controller managing all navigation functions on the website
 * @author    Created by Antoine Roulin
 * @version   10.02.2023
 */

/**
 * @brief This function is designed to redirect the user on the home page when requested
 */
function home(){
    require_once dirname(__FILE__)."/../view/home.php";
}

function displayRegister(){
    require_once dirname(__FILE__)."/../view/register.php";
}

