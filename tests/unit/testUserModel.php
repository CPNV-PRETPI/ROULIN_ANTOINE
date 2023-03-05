<?php
/**
 * @file      testUserModel.php
 * @brief     This file is the test file is used to test function that concern User in the userModel.php file
 * @author    Created by Antoine Roulin
 * @version   03.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../model/userModel.php";

class testUserModel extends TestCase
{
    private array $userTestData = [];
    private array $loginData = [];
    public function setUp(): void
    {
        $this->userTestData['userEmail'] = 'unittest@test.ch';
        $this->userTestData['userUsername'] = 'unittest';
        $this->userTestData['userPassword'] = '1234';
        $this->userTestData['userPasswordVerify'] = '1234';
    }

    public function testCheckData_DataMeetDatabaseExpectation_Success(){
        //Given
        //When
        //Then
        $this->assertTrue(checkData($this->userTestData));
    }

    public function testCheckData_DataDoesntMeetDatabaseExpectation_Success(){
        //Given
        $this->userTestData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char, database expect max of 50 char
        //When
        //Then
        $this->assertFalse(checkData($this->userTestData));
    }

    public function testCheckPasswordMatching_TwoPasswordMatch_Success(){
        //Given
        //When
        //Then
        $this->assertTrue(checkPasswordMatching($this->userTestData));
    }

    public function testCheckPasswordMatching_TwoPasswordDoesntMatch_Success(){
        //Given
        $this->userTestData['userPasswordVerify'] = '5678'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->assertFalse(checkPasswordMatching($this->userTestData));
    }

    public function testDoesMemberExist_UserDoesntExist_Success(){
        //Given
        //When
        //Then
        $this->assertFalse(doesMemberExist($this->userTestData));
    }

    public function testDoesMemberExist_UserAlreadyExist_Success(){
        //Given
        addUser($this->userTestData);
        //When
        //Then
        $this->assertTrue(doesMemberExist($this->userTestData['userEmail']));
    }

    public function testAddUser_NominalCase_Success(){
        //Given
        //When
        addUser($this->userTestData);
        //Then
        $this->assertTrue(doesMemberExist($this->userTestData['userEmail']));
    }

    public function testRegister_NominalCase_Success(){
        //Given
        //When
        register($this->userTestData);
        //Then
        $this->assertTrue(doesMemberExist($this->userTestData['userEmail']));
    }

    public function testRegister_UserAlreadyExist_ThrowException(){
        //Given
        addUser($this->userTestData);
        //When
        //Then
        $this->expectException(memberAlreadyExist::class);
        register($this->userTestData);
    }

    public function testRegister_UserFormNotMeetDataBaseRequirement_ThrowException(){
        //Given
        $this->userTestData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char, database expect max of 50 char
        //When
        //Then
        $this->expectException(notMeetDatabaseRequirement::class);
        register($this->userTestData);
    }

    public function testRegister_UserTwoPasswordDoesntMatch_ThrowException(){
        //Given
        $this->userTestData['userPasswordVerify'] = '5678'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->expectException(twoPasswordDontMatch::class);
        register($this->userTestData);
    }

    public function testLogin_NominalCase_Success(){
        //Given
        register($this->userTestData);
        //When
        //Then
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
        if (doesMemberExist($this->userTestData["userEmail"])){
            $this->cleanUser();
        }
    }
}