<?php

namespace SF\Libs;

use SF\Core\CSRF;

/**
 * Simple Logger
 * 
 * Provides basic logging functionality for security events and errors
 * Uses file-based logging with no external dependencies
 */
class Logger
{
    private static string $logDirectory = 'Logs/';
    private static string $defaultLogFile = 'app.log';

    /**
     * ensureLogDirectory
     *
     * Ensures the log directory exists
     * 
     * @return bool True if directory exists or was created
     */
    private static function ensureLogDirectory()
    {
        if (!file_exists(self::$logDirectory)) {
            return mkdir(self::$logDirectory, 0755, true);
        }
        return true;
    }

    /**
     * writeLog
     *
     * Writes a log entry to the specified log file
     * 
     * @param string $message Log message
     * @param string $level Log level (INFO, WARNING, ERROR, CRITICAL)
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    private static function writeLog($message, $level, $logFile)
    {
        if (!self::ensureLogDirectory()) {
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
     * info
     *
     * Logs an informational message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function info($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::writeLog($message, 'INFO', $logFile);
    }

    /**
     * warning
     *
     * Logs a warning message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function warning($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::writeLog($message, 'WARNING', $logFile);
    }

    /**
     * error
     *
     * Logs an error message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function error($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::writeLog($message, 'ERROR', $logFile);
    }

    /**
     * critical
     *
     * Logs a critical error message
     * 
     * @param string $message Log message
     * @param string $logFile Log file name
     * @return bool True if successful
     */
    public static function critical($message, $logFile = null)
    {
        $logFile = $logFile ?: self::$defaultLogFile;
        return self::writeLog($message, 'CRITICAL', $logFile);
    }

    /**
     * authAttempt
     *
     * Logs an authentication attempt
     * 
     * @param string $username Username attempted
     * @param bool $success Whether login was successful
     * @return bool True if successful
     */
    public static function authAttempt($username, $success)
    {
        $status = $success ? 'SUCCESS' : 'FAILED';
        $message = "Authentication attempt for user '$username': $status";
        return self::writeLog($message, 'INFO', 'auth.log');
    }

    /**
     * securityEvent
     *
     * Logs a security-related event
     * 
     * @param string $event Event description
     * @return bool True if successful
     */
    public static function securityEvent($event)
    {
        return self::writeLog($event, 'WARNING', 'security.log');
    }

    /**
     * queryLog
     *
     * Logs a database query (only when debug mode is enabled)
     * 
     * @param string $query SQL query
     * @param float $executionTime Execution time in seconds
     * @return bool True if successful
     */
    public static function queryLog($query, $executionTime = 0)
    {
        // Only log queries in debug mode
        if (!defined('_Debug') || !_Debug) {
            return false;
        }

        $message = "Query: $query | Execution time: " . number_format($executionTime, 4) . "s";
        return self::writeLog($message, 'DEBUG', 'queries.log');
    }
}
