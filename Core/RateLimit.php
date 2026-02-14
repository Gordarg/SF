<?php

/**
 * Rate Limiting
 * 
 * Simple IP-based rate limiting for authentication endpoints
 * Protects against brute force attacks
 */

class RateLimit {

    private $maxAttempts = 5;
    private $lockoutTime = 900; // 15 minutes in seconds
    private $useAPCu = false;
    private $storageFile = '';

    /**
     * __construct
     *
     * Initialize rate limiter with appropriate storage backend
     * 
     * @return void
     */
    public function __construct()
    {
        // Check if APCu is available for better performance
        $this->useAPCu = function_exists('apcu_fetch') && apcu_enabled();
        
        // If using file storage, set storage path
        if (!$this->useAPCu) {
            $this->storageFile = sys_get_temp_dir() . '/sf_rate_limit.json';
        }
    }

    /**
     * GetClientIdentifier
     *
     * Gets a unique identifier for the client
     * 
     * @return string Client IP address
     */
    private function GetClientIdentifier()
    {
        // Get real IP address (consider proxy headers)
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Check for proxy headers (only if you trust your proxy)
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ipList[0]);
        }
        
        return $ip;
    }

    /**
     * GetAttempts
     *
     * Gets the number of failed attempts for a client
     * 
     * @param string $identifier Client identifier
     * @return array Attempt data
     */
    private function GetAttempts($identifier)
    {
        $key = 'rate_limit_' . md5($identifier);
        
        if ($this->useAPCu) {
            $data = apcu_fetch($key);
            return $data !== false ? $data : ['count' => 0, 'timestamp' => time()];
        } else {
            // File-based storage fallback
            if (file_exists($this->storageFile)) {
                $data = json_decode(file_get_contents($this->storageFile), true);
                if (isset($data[$key])) {
                    return $data[$key];
                }
            }
            return ['count' => 0, 'timestamp' => time()];
        }
    }

    /**
     * SetAttempts
     *
     * Sets the number of failed attempts for a client
     * 
     * @param string $identifier Client identifier
     * @param array $attemptData Attempt data
     * @return void
     */
    private function SetAttempts($identifier, $attemptData)
    {
        $key = 'rate_limit_' . md5($identifier);
        
        if ($this->useAPCu) {
            apcu_store($key, $attemptData, $this->lockoutTime);
        } else {
            // File-based storage fallback
            $data = [];
            if (file_exists($this->storageFile)) {
                $data = json_decode(file_get_contents($this->storageFile), true);
                if (!is_array($data)) {
                    $data = [];
                }
            }
            $data[$key] = $attemptData;
            
            // Clean up old entries
            foreach ($data as $k => $v) {
                if (isset($v['timestamp']) && (time() - $v['timestamp']) > $this->lockoutTime) {
                    unset($data[$k]);
                }
            }
            
            file_put_contents($this->storageFile, json_encode($data));
        }
    }

    /**
     * CheckRateLimit
     *
     * Checks if the client is rate limited
     * 
     * @return bool True if allowed, false if rate limited
     */
    public function CheckRateLimit()
    {
        $identifier = $this->GetClientIdentifier();
        $attempts = $this->GetAttempts($identifier);
        
        // If lockout time has passed, reset attempts
        if ((time() - $attempts['timestamp']) > $this->lockoutTime) {
            $attempts = ['count' => 0, 'timestamp' => time()];
            $this->SetAttempts($identifier, $attempts);
            return true;
        }
        
        // Check if max attempts exceeded
        if ($attempts['count'] >= $this->maxAttempts) {
            $remainingTime = $this->lockoutTime - (time() - $attempts['timestamp']);
            throw new Exception("Too many failed login attempts. Please try again in " . ceil($remainingTime / 60) . " minutes.");
        }
        
        return true;
    }

    /**
     * RecordFailedAttempt
     *
     * Records a failed login attempt
     * 
     * @return void
     */
    public function RecordFailedAttempt()
    {
        $identifier = $this->GetClientIdentifier();
        $attempts = $this->GetAttempts($identifier);
        
        // If this is a new attempt window, reset
        if ((time() - $attempts['timestamp']) > $this->lockoutTime) {
            $attempts = ['count' => 1, 'timestamp' => time()];
        } else {
            $attempts['count']++;
        }
        
        $this->SetAttempts($identifier, $attempts);
    }

    /**
     * ResetAttempts
     *
     * Resets failed attempts on successful login
     * 
     * @return void
     */
    public function ResetAttempts()
    {
        $identifier = $this->GetClientIdentifier();
        $this->SetAttempts($identifier, ['count' => 0, 'timestamp' => time()]);
    }
}
