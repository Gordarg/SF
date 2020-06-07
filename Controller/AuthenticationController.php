<?php

/**
 * 
 * Controller class for authentiction pages
 * 
 */
class AuthenticationController extends Controller {

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
     * LoginPOST
     *
     * Does login action
     * 
     * @return void
     */
    function LoginPOST() {

        $Values = [
            'Username' => $_POST['UsernameInput'],
            'Password' => (new Cryptography())->Encrypt($_POST['PasswordInput'])
        ];

        $Model = $this->CallModel("User");
        $Rows = $Model->CheckLogin($Values);

        if (count($Rows) == 1) {

            // Set cookies
            setcookie("UserId", $Rows[0]['Id'], time() + (2 * 86400 * 15), "/"); // Keep cookies for next two days
            setcookie("Username", $_POST['UsernameInput'], time() + (2 * 86400 * 15), "/");

            // Response redirect
            $this->RedirectResponse(_Root . "Admin/Index");
        } else {
            $this->Render('Login', [
                "Title" => "ورود",
                "Message" => "نام کاربری یا کلمه‌ی عبور معتبر نیست"
            ]);
        }
        
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