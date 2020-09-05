<?php

class Middleware {

    /**
     * GetPreviouslyDefinedInstance
     * 
     * Get the instance of object if was created before.
     * 
     * @param string $ClassName
     * 
     * @return void
     * 
     */
    static function GetPreviouslyDefinedInstance($ClassName) {
    
        // METHOD 1
        // $non_user_vars = ["_COOKIE", "_ENV", "_FILES", "_GET", "_POST", "_REQUEST", 
        //           "_SERVER", "_SESSION", "argc", "argv", "GLOBALS",
        //           "HTTP_RAW_POST_DATA", "http_response_header",
        //           "ignore", "php_errormsg"];
        // $safe_user_vars = ["page"];
        // $all_vars = array_keys($GLOBALS);
        // $user_vars = array_diff($all_vars, $non_user_vars, $safe_user_vars);

        // METHOD 2
        // $user_vars = get_defined_vars()

        // METHODS CONCLUSION
        // foreach ($user_vars as $variable) {
        //     if ($variable instanceof $ClassName)
        //     {
        //     }
        // }




    }

    /**
     * CallModel
     *
     * Sets, calls, and loads the model
     * 
     * @param string $Entity
     *
     * @return void
     */
    static function CallModel($Entity, $UsePDO = true){
        // include_once the model
        include_once('Model/' . $Entity . '.php');
        // if (!@include('Model/' . $Entity . '.php')) // Just a programming joke
        //     include('Model/' . $Entity . '.php');
            
        // Create an instance of object
        return new $Entity($UsePDO);
    }

    /**
     * GetUserFunctionArgumentNames
     * 
     * Gets attributes/paramters/arguments names
     * of a function in runtime dynamically.
     * 
     * 
     */
    static function GetUserFunctionArgumentNames($pair){
        $ReflectClass = new ReflectionClass($pair[0]);
        $ReflectMethod = $ReflectClass->getMethod($pair[1]);
        $Paramters = $ReflectMethod->getParameters();
        $ParamterNames = array();
        foreach($Paramters as $Paramter)
        {
            array_push($ParamterNames, $Paramter->getName());
        }
        return $ParamterNames;
    }
}