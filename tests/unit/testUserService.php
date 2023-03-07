<?php
/**
 * @file      testUserService.php
 * @brief     This file is the test file is used to test function that concern User in the userController.php file
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../model/userService.php";

class testUserService extends TestCase
{
    private array $userTestData = [];
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
        $this->expectException(MemberAlreadyExist::class);
        register($this->userTestData);
    }

    public function testRegister_UserFormNotMeetDataBaseRequirement_ThrowException(){
        //Given
        $this->userTestData['userUsername'] = '5JeJMu3kn3JHgApatT9YqyUjCMPD7PaE7aycDhtRdnzQPtqBad212'; //Username of exactly 53 char, database expect max of 50 char
        //When
        //Then
        $this->expectException(NotMeetDatabaseRequirement::class);
        register($this->userTestData);
    }

    public function testRegister_UserTwoPasswordDoesntMatch_ThrowException(){
        //Given
        $this->userTestData['userPasswordVerify'] = 'NotTheSamePassword'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->expectException(TwoPasswordDontMatch::class);
        register($this->userTestData);
    }

    /**
     * Difference between assertEquals() and assertSame() is that assertEquals() try to match only the value of the expected and actual value and assertSame() will try to match the value and type of the data of the expected and actual
     * @link : https://stackoverflow.com/questions/10254180/difference-between-assertequals-and-assertsame-in-phpunit
     */
    public function testLogin_NominalCase_Success(): void
    {
        //Given
        register($this->userTestData);
        //When
        login($this->userTestData);
        //Then
        $this->assertEquals($this->userTestData['userUsername'],$_SESSION['username']);
    }

    public function testLogin_MemberDoesntExist_Success(): void
    {
        //Given
        //When
        //Then
        $this->expectException(memberDoesntExist::class);
        login($this->userTestData);
    }

    public function testLogin_MemberExistButWithWrongCredentials_Success(): void
    {
        //Given
        register($this->userTestData);
        $this->userTestData['userPassword'] = "NotTheSamePassword"; //Set userTestData['userPassword'] with not the password of the member this member in the database
        //When
        //Then
        $this->expectException(wrongLoginCredentials::class);
        login($this->userTestData);
    }

    public function testLogout_SessionComingFromRegister_Success(): void
    {
        //Given
        register($this->userTestData);
        //When
        logout();
        //Then
        $this->assertEquals(null, $_SESSION);
    }

    public function testLogout_SessionComingFromLogin_Success(): void
    {
        //Given
        register($this->userTestData);
        logout();
        //When
        login($this->userTestData);
        logout();
        //Then
        $this->assertEquals(null, $_SESSION);
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