<?php
/**
 * @file      testUser.php
 * @brief     This file is the test file is used to test function that concerne User
 * @author    Created by Antoine Roulin
 * @version   27.02.2023
 */


require "../../controller/userController.php";

class testUser extends \PHPUnit\Framework\TestCase
{
    public function testUserRegisterFull(){

        // create the post request array
        $_POST['userEmail'] = 'unittest@test.ch';
        $_POST['userUsername'] = 'unittest';
        $_POST['userPassword'] = '1234';
        $_POST['userPasswordVerify'] = '1234';

        // register the new user with the array
        register($_POST);

        // check if the created user exists
        try{
            ifMemberExist($_POST['userEmail']);
            // the user doesn't exists in the database
            $isUserExists = false;
        }
        catch(registeredException){
            // the user exists in the database
            $isUserExists = true;
        }
        catch(databaseException){
            $isUserExists = false;
        }

        $this->assertEquals(True, $isUserExists);

        // clean
        $this->cleanUser();
    }

    public function testUserRegisterPasswordNotTheSame(){

        // create the post request array
        $_POST['userEmail'] = 'unittest@test.ch';
        $_POST['userUsername'] = 'unittest';
        $_POST['userPassword'] = '1234';
        $_POST['userPasswordVerify'] = 'paslememe';

        // register the new user with the array
        register($_POST);

        // check if the created user exists
        try{
            ifMemberExist($_POST['userEmail']);
            // the user doesn't exists in the database
            $isUserExists = false;
        }
        catch(registeredException){
            // the user exists in the database
            $isUserExists = true;
        }
        catch(databaseException){
            $isUserExists = false;
        }

        $this->assertEquals(False, $isUserExists);

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
}