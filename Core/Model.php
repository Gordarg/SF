<?php

/**
 * 
 * Master class for models
 * 
 */
class Model{

    public static $Connection = '';

    /**
     * __toString
     *
     * Returns the connection stirng
     * 
     * @return string ConnectionString
     */
    public function __toString()
    {
        return 'mysql:host=' . _DatabaseServer . ';dbname=' . _DatabaseName;
    }

    
    /**
     * __construct
     *
     * Create a connection to database
     * 
     * @return void
     */
    function __construct($PDO=true)
    {
        if ($PDO)
        {
            // Use utf8mb4 for full Unicode support (including emojis)
            $ConnectionParameters = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');
            
            try {
                self::$Connection = new PDO((string)$this,  _DatabaseUsername, _DatabasePassword, $ConnectionParameters);
                
                if (_Debug)
                    self::$Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                else
                    self::$Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            } catch (PDOException $e) {
                // Log error securely
                if (class_exists('Logger')) {
                    Logger::Critical('Database connection failed: ' . $e->getMessage());
                }
                
                // Show generic error to user (don't expose details in production)
                if (_Debug) {
                    throw $e;
                } else {
                    throw new Exception('Database connection failed. Please contact administrator.');
                }
            }
        }
        else
        {
            self::$Connection = new mysqli(_DatabaseServer
            , _DatabaseUsername
            , _DatabasePassword
            , _DatabaseName);
            
            // Check for connection errors
            if (self::$Connection->connect_error) {
                if (class_exists('Logger')) {
                    Logger::Critical('MySQL connection failed: ' . self::$Connection->connect_error);
                }
                
                if (_Debug) {
                    throw new Exception('MySQL connection failed: ' . self::$Connection->connect_error);
                } else {
                    throw new Exception('Database connection failed. Please contact administrator.');
                }
            }
            
            // Use utf8mb4 for full Unicode support
            mysqli_set_charset(self::$Connection, "utf8mb4");
        }
    }


    /**
     * DoSelect
     *
     * Runs a select query with optional query logging
     * 
     * @param  mixed $Query
     * @param  mixed $Values
     * @param  mixed $FetchStyle
     *
     * @return array Query outputs
     */
    function DoSelect($Query, $Values = [], $FetchStyle = PDO::FETCH_ASSOC)
    {
        // Log query start time if debug mode enabled
        $startTime = _Debug ? microtime(true) : 0;
        
        $LiveConnection = self::$Connection->prepare($Query);
        foreach ($Values as $Key => $Value) {
            if (gettype($Value) == "integer" || gettype($Value) == "boolean") // Recommended for bit(1) values
                $LiveConnection->bindValue($Key, $Value, PDO::PARAM_INT);
            else
                $LiveConnection->bindValue($Key, $Value);
        }
        $LiveConnection->execute();
        $Result = $LiveConnection->fetchAll($FetchStyle);
        
        // Log query if debug mode enabled
        if (_Debug && class_exists('Logger')) {
            $executionTime = microtime(true) - $startTime;
            Logger::QueryLog($Query, $executionTime);
        }
        
        return $Result;
    }


    /**
     * DoQuery
     *
     * Runs an executing query with optional query logging
     * 
     * @param  mixed $Query
     * @param  mixed $Values
     *
     * @return void
     */
    function DoQuery($Query, $Values = [])
    {
        // Log query start time if debug mode enabled
        $startTime = _Debug ? microtime(true) : 0;
        
        $LiveConnection = self::$Connection->prepare($Query);
        foreach ($Values as $Key => $Value) {
            if (gettype($Value) == "integer" || gettype($Value) == "boolean") // Recommended for bit(1) values
                $LiveConnection->bindValue($Key, $Value, PDO::PARAM_INT);
            else
                $LiveConnection->bindValue($Key, $Value);
        }
        
        $result = $LiveConnection->execute();
        
        // Log query if debug mode enabled
        if (_Debug && class_exists('Logger')) {
            $executionTime = microtime(true) - $startTime;
            Logger::QueryLog($Query, $executionTime);
        }
        
        return $result;
    }
}