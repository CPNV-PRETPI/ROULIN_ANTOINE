<?php
/**
 * @file      testUserModel.php
 * @brief     This file is the test file is used to test function that concern User in the userModel.php file
 * @author    Created by Antoine Roulin
 * @version   03.03.2023
 */

require "../../model/userModel.php";


class testUserModel extends \PHPUnit\Framework\TestCase
{
    private array $registerData = [];

    public function setUp(): void
    {
        $this->registerData['userEmail'] = 'unittest@test.ch';
        $this->registerData['userUsername'] = 'unittest';
        $this->registerData['userPassword'] = '1234';
        $this->registerData['userPasswordVerify'] = '1234';
    }

    public function testCheckData_DataMeetDatabaseExpectation_Success(){
        //Given
        //When
        //Then
        $this->assertTrue(checkData($this->registerData));
    }

    public function testCheckData_DataDoesntMeetDatabaseExpectation_Success(){
        //Given
        $this->registerData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char, database expect max of 50 char
        //When
        //Then
        $this->assertFalse(checkData($this->registerData));
    }

    public function testCheckPasswordMatching_TwoPasswordMatch_Success(){
        //Given
        //When
        //Then
        $this->assertTrue(checkPasswordMatching($this->registerData));
    }

    public function testCheckPasswordMatching_TwoPasswordDoesntMatch_Success(){
        //Given
        $this->registerData['userPasswordVerify'] = '5678'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->assertFalse(checkPasswordMatching($this->registerData));
    }

    public function testDoesMemberExist_UserDoesntExist_Success(){
        //Given
        //When
        //Then
        $this->assertFalse(doesMemberExist($this->registerData));
    }

    public function testDoesMemberExist_UserAlreadyExist_Success(){
        //Given
        addUser($this->registerData);
        //When
        //Then
        $this->assertTrue(doesMemberExist($this->registerData['userEmail']));
    }

    public function testAddUser_NominalCase_Success(){
        //Given
        //When
        addUser($this->registerData);
        //Then
        $this->assertTrue(doesMemberExist($this->registerData['userEmail']));
    }

    public function testRegister_NominalCase_Success(){
        //Given
        //When
        register($this->registerData);
        //Then
        $this->assertTrue(doesMemberExist($this->registerData['userEmail']));
    }

    public function testRegister_UserAlreadyExist_ThrowException(){
        //Given
        addUser($this->registerData);
        //When
        //Then
        $this->expectException(memberAlreadyExist::class);
        register($this->registerData);
    }

    public function testRegister_UserFormNotMeetDataBaseRequirement_ThrowException(){
        //Given
        $this->registerData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char, database expect max of 50 char
        //When
        //Then
        $this->expectException(notMeetDatabaseRequirement::class);
        register($this->registerData);
    }

    public function testRegister_UserTwoPasswordDoesntMatch_ThrowException(){
        //Given
        $this->registerData['userPasswordVerify'] = '5678'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->expectException(twoPasswordDontMatch::class);
        register($this->registerData);
    }

    public function cleanUser(){
        require_once "../../model/dbConnector.php";
        try {
            $query = "DELETE FROM accounts WHERE email_address = 'unittest@test.ch'";
            executeQuery($query);
        }
        catch (databaseException){
            print 'Database error';
        }
    }

    public function tearDown(): void
    {
        // clean
        if (doesMemberExist($this->registerData["userEmail"])){
            $this->cleanUser();
        }
    }
}