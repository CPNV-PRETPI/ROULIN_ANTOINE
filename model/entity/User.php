<?php

class User
{
    private string $email;
    private string $password;
    public function __construct($email)
    {
        $this->email = $email;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}