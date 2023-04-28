<?php
/**
 * @file      User.php
 * @brief     This file is the entity user. It contains all the information about a user and the functions to get them.
 * @author    Created by Antoine Roulin
 * @version   28.04.2023
 */

class User
{
    private string $email;
    public function __construct($email)
    {
        $this->email = $email;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}