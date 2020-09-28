<?php

/**
 * 
 * Class in common between Controllers and ApiControllers
 * Handling authentication and authorization
 * 
 */

class Auth {

    protected $ParentController;

    function __construct($ParentController) {
        $this->ParentController = $ParentController;
    }

    /**
     * CheckLogin
     *
     * Checks the Person role and login
     * 
     * @param  mixed $Data
     * @param  mixed $Role
     *
     * @return void
     */
    function CheckLogin($Data, $Role = 'admin')
    {

        // If php_auth_user is denied on server and
        // RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
        // is enabled in .htaccess
        // then manualy set the auth info
        if (isset($_SERVER['HTTP_AUTHORIZATION'])
            and $_SERVER['HTTP_AUTHORIZATION'] != '')
            list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = 
                explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        // Check admins with the .htpasswd file
        if ($Role == 'admin')
        {
            // Read the passwords file
            $Lines = array();
            if ($file = fopen(".htpasswd", "r")) {
                while(!feof($file)) {
                    array_push($Lines,fgets($file));
                }
                fclose($file);
            }

            // Break to lines to two dimensional array
            $Credits = array_map(function($val) {
                if ($val)
                    return explode(':', $val);
            }, $Lines);
            
            // Check if pasword is sent
            if (!isset($Data['Username'])) {
                a:
                throw new UnauthException();
            } else {
                // Check passwords
                foreach ($Credits as $Credit)
                {                   
                    // Check username
                    if ($Data['Username'] != $Credit[0])
                        continue;

                    // Check plaintext password against an APR1-MD5 hash
                    $plain_text_passwd = $Data['Password'];
                    $check_result = APR1_MD5::check($plain_text_passwd, rtrim($Credit[1]));

                    // If not correct
                    if (!$check_result)
                        throw new UnauthException();

                    // If correct
                    return true;
                    
                }
                // If failed
                goto a;
            }
        }

        // Check others with database
        else
        {

            $Values = [
                'Username' => $Data['Username'],
                'Password' => (new Cryptography())->Encrypt($Data['Password'])
            ];

            $Model = $this->ParentController->CallModel('Authentication');
            $Entity = $Model->ValidatePersonPass($Values);

            // TODO: Check sessions

            return (count($Entity) == 1);
        }
    }

}