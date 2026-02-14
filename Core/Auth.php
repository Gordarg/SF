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
     * Includes rate limiting to prevent brute force attacks
     * 
     * @param  mixed $Data
     * @param  mixed $Role
     *
     * @return void
     */
    function CheckLogin($Data, $Role = 'admin')
    {
        // Initialize rate limiter
        $rateLimiter = new RateLimit();
        
        // Check rate limit before attempting authentication
        try {
            $rateLimiter->CheckRateLimit();
        } catch (Exception $e) {
            // Log rate limit hit
            if (class_exists('Logger')) {
                Logger::SecurityEvent('Rate limit exceeded for authentication attempt');
            }
            throw new UnauthException($e->getMessage());
        }

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
                    if (!$check_result) {
                        // Record failed attempt
                        $rateLimiter->RecordFailedAttempt();
                        
                        // Log failed attempt
                        if (class_exists('Logger')) {
                            Logger::AuthAttempt($Data['Username'], false);
                        }
                        
                        throw new UnauthException();
                    }

                    // If correct - reset rate limit and log success
                    $rateLimiter->ResetAttempts();
                    
                    if (class_exists('Logger')) {
                        Logger::AuthAttempt($Data['Username'], true);
                    }
                    
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

            $isValid = (count($Entity) == 1);
            
            // Handle rate limiting
            if (!$isValid) {
                $rateLimiter->RecordFailedAttempt();
                
                if (class_exists('Logger')) {
                    Logger::AuthAttempt($Data['Username'], false);
                }
            } else {
                $rateLimiter->ResetAttempts();
                
                if (class_exists('Logger')) {
                    Logger::AuthAttempt($Data['Username'], true);
                }
            }

            // TODO: Check sessions

            return $isValid;
        }
    }

}