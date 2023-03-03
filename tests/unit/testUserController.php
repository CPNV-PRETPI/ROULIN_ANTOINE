<?php
/**
 * @file      testUserController.php
 * @brief     This file is the test file is used to test function that concern User in the userController.php file
 * @author    Created by Antoine Roulin
 * @version   03.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../controller/userController.php";

class testUserController extends TestCase
{
    private array $registerData = [];

    public function setUp(): void
    {
        $this->registerData['userEmail'] = 'unittest@test.ch';
        $this->registerData['userUsername'] = 'unittest';
        $this->registerData['userPassword'] = '1234';
        $this->registerData['userPasswordVerify'] = '1234';
    }

    public function testRegisterUser_NominalCase_Success(){
        //Given
        //When
        //Then
    }

    public function checkUserHasBeenRegistered(){
        require_once "../../model/dbConnector.php";
        try {
            $query = "SELECT email FROM accounts WHERE email ='" . $this->registerData['userEmail'] ."';";
            executeQuery($query);
        }
        catch (databaseException){
            print 'Database error';
        }
    }

    public function cleanUser(){
        require_once "../../model/dbConnector.php";
        try {
            $query = "DELETE FROM accounts WHERE email ='" . $this->registerData['userEmail'] ."';";
            executeQuery($query);
        }
        catch (databaseException){
            print 'Database error';
        }
    }

    public function tearDown(): void
    {
        // clean
        require_once "../../model/userModel.php";
        if (doesMemberExist($this->registerData["userEmail"])){
            $this->cleanUser();
        }
    }
}
