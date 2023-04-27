<?php

class User
{
    private string $username;
    private string $email;
    private string $password;
    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}