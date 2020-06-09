<?php

class Middleware {
    /**
     * CallModel
     *
     * Sets, calls, and loads the model
     * 
     * @param string $Entity
     *
     * @return void
     */
    function CallModel(string $Entity){
        include('Model/' . $Entity . '.php');
        return new $Entity;
    }
}