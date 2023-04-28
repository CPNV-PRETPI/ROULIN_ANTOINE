<?php

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