<?php
/**
 * @file      testUserController.php
 * @brief     This file is the test file is used to test function that concern User in the userController.php file
 * @author    Created by Antoine Roulin
 * @version   04.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../controller/userController.php";

class testUserController extends TestCase
{
    private array $userTestData = [];

    public function setUp(): void
    {
        $this->userTestData['userEmail'] = 'unittest@test.ch';
        $this->userTestData['userUsername'] = 'unittest';
        $this->userTestData['userPassword'] = '1234';
        $this->userTestData['userPasswordVerify'] = '1234';
    }

    public function testRegisterUser_NominalCase_Success(){
        //Given
        //When
        registerUser($this->userTestData);
        //Then
        $this->assertTrue($this->checkUserHasBeenRegistered());
    }

    public function testLoginUser_NominalCase_Success(){
        //Given
        registerUser($this->userTestData);
        //When
        loginUser($this->userTestData);
        //Then
        $this->assertEquals($this->userTestData['userUsername'],$_SESSION['username']);
    }

    /* Try to create a test that test the RegisterUser function not in the nominal case
    public function testRegisterUser_TwoPasswordNotMatch_Success(){
        //Given
        $this->userTestData['userPasswordVerify'] = '5678';
        //When
        registerUser($this->userTestData);
        //Then
        $this->assertEquals("The two passwords you entered are not the same", $error);
    }
    */

    public function checkUserHasBeenRegistered() : bool
    {
        require_once "../../model/dbConnector.php";
        $query = "SELECT email FROM accounts WHERE email ='" . $this->userTestData['userEmail'] ."';";
        $queryResult = executeQueryReturn($query);
        if(count($queryResult) == 1){
            return true;
        }
        return false;
    }

    public function cleanUser(){
        require_once "../../model/dbConnector.php";
        try {
            $query = "DELETE FROM accounts WHERE email ='" . $this->userTestData['userEmail'] ."';";
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
        if (doesMemberExist($this->userTestData["userEmail"])){
            $this->cleanUser();
        }
    }
}
