<?php
/**
 * @file      testUserController.php
 * @brief     This file is the test file is used to test function that concern User in the userController.php file
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../controller/userController.php";

class testUserController extends TestCase
{
    private array $userTestData = [];

    public function setUp(): void
    {
        $this->userTestData['userEmail'] = 'unittest@test.ch';
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
        $this->assertEquals($this->userTestData['userEmail'],$_SESSION['email']);
    }

    public function testLogout_SessionComingFromRegister_Success(): void
    {
        //Given
        registerUser($this->userTestData);
        //When
        logoutUser();
        //Then
        $this->assertEquals(null, $_SESSION);
    }

    public function testLogout_SessionComingFromLogin_Success(): void
    {
        //Given
        registerUser($this->userTestData);
        logoutUser();
        //When
        loginUser($this->userTestData);
        logoutUser();
        //Then
        $this->assertEquals(null, $_SESSION);
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
        require_once "../../model/data/dbConnector.php";
        $query = "SELECT email FROM accounts WHERE email ='" . $this->userTestData['userEmail'] ."';";
        $queryResult = executeQuery($query);
        if(count($queryResult) == 1){
            return true;
        }
        return false;
    }

    public function cleanUser(){
        require_once "../../model/data/dbConnector.php";
        $query = "DELETE FROM accounts WHERE email ='" . $this->userTestData['userEmail'] ."';";
        executeQuery($query);
    }

    public function tearDown(): void
    {
        // clean
        require_once "../../model/service/userService.php";
        if (doesMemberExist($this->userTestData["userEmail"])){
            $this->cleanUser();
        }
    }
}
