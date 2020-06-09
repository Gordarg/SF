<?php

/**
 * 
 * Controller class for authentiction pages
 * 
 */
class AuthenticationController extends Controller {

    /**
     * 
     * BasicGET
     * 
     * Responsible for Basic Authentication
     * 
     */
    function BasicGET() {

        try{
            $Login = $this->CheckLogin();
        } catch (Exception $xep) {
            $Login = false;
        }
        
        // If valid credintials
        if ($Login) {
            
            // Set cookies
            setcookie("Username", $_SERVER['PHP_AUTH_USER'], time() + (2 * 86400 * 15), "/"); // Keep cookies for next two days
            setcookie("Password", $_SERVER['PHP_AUTH_PW'], time() + (2 * 86400 * 15), "/"); // Keep cookies for next two days
            
            // Response redirect
            $this->RedirectResponse(_Root . "Admin/Index");
        }
        // If wasn't logged in
        else {
            header('WWW-Authenticate: Basic realm="protected_area"');
            header('HTTP/1.0 401 Unauthorized');
            // $this->RedirectResponse(_Root . "Authentication/Login");

        }
    }


    /**
     * LoginGET
     *
     * Shows up login form
     * 
     * @return void
     */
    function LoginGET() {
        $this->Render('Login', [
            "Title" => "ورود"
        ]);
    }

    /**
     * LogoutGET
     *
     * Does logout action
     * 
     * @return void
     */
    function LogoutGET() {
        $this->CheckLogin(); // Check login

        // Http authentication reset
        header('WWW-Authenticate: Basic realm="protected_area"');
        header('HTTP/1.0 401 Unauthorized');
        
        // Unset the cookies
        unset($_COOKIE['UserId']);
        unset($_COOKIE['Username']);
        setcookie('UserId', null, -1, '/');
        setcookie('Username', null, -1, '/');

        // Render logout form
        $this->Render('Login', [
            "Title" => "خروج",
            "Message" => "شما از سیستم خارج شدید"
        ]);
        
    }

}