<?php
/**
 * @file      testUserModel.php
 * @brief     This file is the test file is used to test function that concerne User in the userModel.php file
 * @author    Created by Antoine Roulin
 * @version   01.03.2023
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
        $this->registerData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad'; //Username of exactly 50 char
        //When
        //Then
        $this->assertTrue(checkData($this->registerData));
    }

    public function testCheckData_DataDoesntMeetDatabaseExpectation_Success(){
        //Given
        $this->registerData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char
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
        $this->registerData['userPasswordVerify'] = '5678';
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

    public function testRegistering_UserExist_Success(){
        //Given
        registering($this->registerData);
        //When
        //Then
    }

    public function testDoesExist_UserExist_Success(){
        //Given
        registering($this->registerData);
        //When
        //Then
        $this->assertTrue(doesMemberExist($this->registerData["userEmail"]));
    }

    public function testDoesExist_UserDoesntExist_Success(){
        //Given
        //When
        //Then
        $this->assertFalse(doesMemberExist($this->registerData["userEmail"]));
    }

    public function testRegister_NominalCase_Success()
    {
        //Given
        // create the post request array


        //When
        // register the new user with the array
        register($this->registerData);

        //Then
        $this->assertEquals(True, $doesUserExists);

    }

    public function testRegister_UserAlreadyExist_ThrowException()
    {
        //Given
        // create the post request array
        $this->registerData['userEmail'] = 'unittest@test.ch';
        $this->registerData['userUsername'] = 'unittest';
        $this->registerData['userPassword'] = '1234';
        $this->registerData['userPasswordVerify'] = '1234';
        register($this->registerData);

        //When
        $this->expectException(registeredException::class);
        register($this->registerData);

        //Then
    }

    public function testUserRegisterPasswordNotTheSame(){

        // create the post request array
        $registerData = [];

        $registerData['userEmail'] = 'unittest@test.ch';
        $registerData['userUsername'] = 'unittest';
        $registerData['userPassword'] = '1234';
        $registerData['userPasswordVerify'] = 'paslememe';

        // register the new user with the array
        register($registerData);

        // check if the created user exists
        try{
            ifMemberExist($registerData['userEmail']);
            // the user doesn't exists in the database
            $doesUserExists = false;
        }
        catch(registeredException){
            // the user exists in the database
            $doesUserExists = true;
        }
        catch(databaseException){
            $doesUserExists = false;
        }

        $this->assertEquals(False, $doesUserExists);

        // clean
        $this->cleanUser();
    }

    public function testUserLogin(){

        // create user

        // login the user with user / password

        // check if the session exists

        $this->assertEquals(True, false);
    }

    public function testUserLogout(){

        // create user

        // login the user with user / password

        // check if session exists

        // logout

        // check is session ended

        $this->assertEquals(True, false);
    }

    public function testUserUnregister(){
        $this->assertEquals(True, false);
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