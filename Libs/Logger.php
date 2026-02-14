<?php

/**
 * Simple Logger
 * 
 * Provides basic logging functionality for security events and errors
 * Uses file-based logging with no external dependencies
 */

class Logger {

    private static $logDirectory = 'Logs/';
    private static $defaultLogFile = 'app.log';

    /**
     * EnsureLogDirectory
     *
     * Ensures the log directory exists
     * 
     * @return bool True if directory exists or was created
     */
    private static function EnsureLogDirectory()
    {
        if (!file_exists(self::$logDirectory)) {
            return mkdir(self::$logDirectory, 0755, true);
        }
        return true;
    }

    /**
     * WriteLog
     *
     * Writes a log entry to the specified log file
     * 
     * @param string $message Log message
     * @param string $level Log level (INFO, WARNING, ERROR, CRITICAL)
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    private static function WriteLog($message, $level, $logFile)
    {
        if (!self::EnsureLogDirectory()) {
            return false;
        }

        $timestamp = date('Y-m-d H:i:s');
        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown';
        $logEntry = "[$timestamp] [$level] [IP: $ipAddress] $message" . PHP_EOL;

        $filePath = self::$logDirectory . $logFile;
        
        // Append to log file
        return file_put_contents($filePath, $logEntry, FILE_APPEND | LOCK_EX) !== false;
    }

    /**
     * Info
     *
     * Logs an informational message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function Info($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::WriteLog($message, 'INFO', $logFile);
    }

    /**
     * Warning
     *
     * Logs a warning message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function Warning($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::WriteLog($message, 'WARNING', $logFile);
    }

    /**
     * Error
     *
     * Logs an error message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function Error($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::WriteLog($message, 'ERROR', $logFile);
    }

    /**
     * Critical
     *
     * Logs a critical error message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function Critical($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::WriteLog($message, 'CRITICAL', $logFile);
    }

    /**
     * AuthAttempt
     *
     * Logs an authentication attempt
     * 
     * @param string $username Username attempted
     * @param bool $success Whether login was successful
     * @return bool True if successful
     */
    public static function AuthAttempt($username, $success)
    {
        $status = $success ? 'SUCCESS' : 'FAILED';
        $message = "Authentication attempt for user '$username': $status";
        return self::WriteLog($message, 'INFO', 'auth.log');
    }

    /**
     * SecurityEvent
     *
     * Logs a security-related event
     * 
     * @param string $event Event description
     * @return bool True if successful
     */
    public static function SecurityEvent($event)
    {
        return self::WriteLog($event, 'WARNING', 'security.log');
    }

    /**
     * QueryLog
     *
     * Logs a database query (only when debug mode is enabled)
     * 
     * @param string $query SQL query
     * @param float $executionTime Execution time in seconds
     * @return bool True if successful
     */
    public static function QueryLog($query, $executionTime = 0)
    {
        // Only log queries in debug mode
        if (!defined('_Debug') || !_Debug) {
            return false;
        }

        $message = "Query: $query | Execution time: " . number_format($executionTime, 4) . "s";
        return self::WriteLog($message, 'DEBUG', 'queries.log');
    }
}
