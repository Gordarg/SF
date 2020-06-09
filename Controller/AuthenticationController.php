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
        
        // If valid credintials
        if ($this->CheckLogin()) {
            
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
        $this->CheckLogin($_COOKIE); // Check login

        // Logout
        header('WWW-Authenticate: Basic realm="protected_area"');
        header('HTTP/1.0 401 Unauthorized');
        
        // $this->RedirectResponse(_Root . "Authentication/Login");
        // throw new AuthException('Logged Out');

        // Render logout form
        $this->Render('Login', [
            "Title" => "خروج",
            "Message" => "شما از سیستم خارج شدید"
        ]);
        
    }

}