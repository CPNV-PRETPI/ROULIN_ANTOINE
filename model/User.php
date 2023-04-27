<?php

class User
{
    private string $username;
    private string $email;
    private string $password;
    public function __construct($email, $username)
    {
        $this->email = $email;
        $this->username = $username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
}