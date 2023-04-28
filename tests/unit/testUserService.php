<?php
/**
 * @file      testUserService.php
 * @brief     This file is the test file is used to test function that concern User in the userController.php file
 * @author    Created by Antoine Roulin
 * @version   05.03.2023
 */

use PHPUnit\Framework\TestCase;

require "../../model/service/userService.php";

class testUserService extends TestCase
{
    private array $userTestData = [];
    private User $user;
    public function setUp(): void
    {
        $this->userTestData['userEmail'] = 'unittest@test.ch';
        $this->userTestData['userPassword'] = '1234';
        $this->userTestData['userPasswordVerify'] = '1234';
        $this->user = new User($this->userTestData['userEmail']);
    }

    public function testCheckData_DataMeetDatabaseExpectation_Success(){
        //Given
        //When
        //Then
        $this->assertTrue(checkData($this->userTestData));
    }

    public function testCheckData_DataDoesntMeetDatabaseExpectation_Success(){
        //Given
        //Email of exactly 330 char, database expect max of 319 char for an email.
        $this->userTestData['userEmail'] =
            '
            6kUabrunLtknLzea2n4nmnvpBYfTqDLWkQ6qPnePpv8y98aTgN28pUfQtfcXzMXkJTm8cG7GxqrMJFUU4uxLrW33UPYxLFpYraL5BLrE9Yw
            9WJM3CwEPf6ZmEKxSJ4EmCj3dCgJnjcQcNGcsYS8Am46JLZ8NmG9ZgH7RemyrZ6WawjP8NEeHh8MPrasxnhtyegVmKpFvHgsxrgkBm5fukz
            NR9k4g42aMjYuzn7eptgamqruErz7KtLCRzCEBcrevmSPvn6ucF69KueUdH89sNK5tBrmRZGr7kBuUDPSuxG7NqMrN3cNr8xapPkWUvxaV@
            gmail.com
            ';
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
        $this->assertFalse(doesMemberExist($this->userTestData['userEmail']));
    }

    public function testDoesMemberExist_UserAlreadyExist_Success(){
        //Given
        addUser($this->userTestData['userPassword'], $this->user);
        //When
        //Then
        $this->assertTrue(doesMemberExist($this->user->getEmail()));
    }

    public function testAddUser_NominalCase_Success(){
        //Given
        //When
        addUser($this->userTestData['userPassword'], $this->user);
        //Then
        $this->assertTrue(doesMemberExist($this->user->getEmail()));
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
        addUser($this->userTestData['userPassword'], $this->user);
        //When
        //Then
        $this->expectException(RegisterException::class);
        register($this->userTestData);
    }

    public function testRegister_UserFormNotMeetDataBaseRequirement_ThrowException(){
        //Given
        //Email of exactly 330 char, database expect max of 319 char for an email.
        $this->userTestData['userEmail'] =
            '
            6kUabrunLtknLzea2n4nmnvpBYfTqDLWkQ6qPnePpv8y98aTgN28pUfQtfcXzMXkJTm8cG7GxqrMJFUU4uxLrW33UPYxLFpYraL5BLrE9Yw
            9WJM3CwEPf6ZmEKxSJ4EmCj3dCgJnjcQcNGcsYS8Am46JLZ8NmG9ZgH7RemyrZ6WawjP8NEeHh8MPrasxnhtyegVmKpFvHgsxrgkBm5fukz
            NR9k4g42aMjYuzn7eptgamqruErz7KtLCRzCEBcrevmSPvn6ucF69KueUdH89sNK5tBrmRZGr7kBuUDPSuxG7NqMrN3cNr8xapPkWUvxaV@
            gmail.com
            ';
        //When
        //Then
        $this->expectException(RegisterException::class);
        register($this->userTestData);
    }

    public function testRegister_UserTwoPasswordDoesntMatch_ThrowException(){
        //Given
        $this->userTestData['userPasswordVerify'] = 'NotTheSamePassword'; //Password not match the password given in the SetUp function
        //When
        //Then
        $this->expectException(RegisterException::class);
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
        $this->expectNotToPerformAssertions();
    }

    public function testLogin_MemberDoesntExist_Success(): void
    {
        //Given
        //When
        //Then
        $this->expectException(MemberDoesntExist::class);
        login($this->userTestData);
    }

    public function testLogin_MemberExistButWithWrongCredentials_Success(): void
    {
        //Given
        register($this->userTestData);
        $this->userTestData['userPassword'] = "NotTheSamePassword"; //Set userTestData['userPassword'] with not the password of the member this member in the database
        //When
        //Then
        $this->expectException(WrongLoginCredentials::class);
        login($this->userTestData);
    }

    public function testCheckRegister_NotMeetDatabaseRequirementThrown_Success() : void {
        //Given
        //Email of exactly 330 char, database expect max of 319 char for an email.
        $this->userTestData['userEmail'] =
            '
            6kUabrunLtknLzea2n4nmnvpBYfTqDLWkQ6qPnePpv8y98aTgN28pUfQtfcXzMXkJTm8cG7GxqrMJFUU4uxLrW33UPYxLFpYraL5BLrE9Yw
            9WJM3CwEPf6ZmEKxSJ4EmCj3dCgJnjcQcNGcsYS8Am46JLZ8NmG9ZgH7RemyrZ6WawjP8NEeHh8MPrasxnhtyegVmKpFvHgsxrgkBm5fukz
            NR9k4g42aMjYuzn7eptgamqruErz7KtLCRzCEBcrevmSPvn6ucF69KueUdH89sNK5tBrmRZGr7kBuUDPSuxG7NqMrN3cNr8xapPkWUvxaV@
            gmail.com
            ';
        //When
        //Then
        $this->expectException(RegisterException::class);
        checkRegister($this->userTestData);
    }

    public function testCheckRegister_TwoPasswordDontMatchThrown_Success() : void {
        //Given
        $this->userTestData['userPasswordVerify'] = 'NotSamePassword';
        //When
        //Then
        $this->expectException(RegisterException::class);
        checkRegister($this->userTestData);
    }

    public function testCheckRegister_MemberAlreadyExistThrown_Success() : void {
        //Given
        addUser($this->userTestData['userPassword'], $this->user);
        //When
        //Then
        $this->expectException(RegisterException::class);
        checkRegister($this->userTestData);
    }

    public function cleanUser(){
        require_once "../../model/data/dbConnector.php";
        $query = "DELETE FROM accounts WHERE email ='" . $this->userTestData['userEmail'] ."';";
        executeQuery($query);
    }

    public function tearDown(): void
    {
        // clean
        if (doesMemberExist($this->userTestData['userEmail'])){
            $this->cleanUser();
        }
    }
}