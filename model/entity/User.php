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

    /**
     * @brief User constructor.
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @brief Get the email of the user.
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @brief Get the password of the user.
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}