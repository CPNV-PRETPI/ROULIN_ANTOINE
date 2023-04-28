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
    private string $password;
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}