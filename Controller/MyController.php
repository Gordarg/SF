<?php

include_once 'MyController.People.php';
include_once 'MyController.CRUD.php';
include_once 'MyController.FileManager.php';

/**
 * 
 * Controller class for private panel
 * 
 */
class MyController extends Controller {

    // About traits: https://www.php.net/manual/en/language.oop5.traits.php

    // Call traits
    use People;
    use CRUD;
    use FileManager;

    /**
     * InterpreterGET
     *
     * View that allows lazy client to
     * load the jquery static forms (webclient)
     * 
     * @return void
     */
    function InterpreterGET() {

        $this->CheckLogin(); // Check login

        $Data = [
            'Title' => 'Title Not Loaded',
        ];

        $this->Render('Interpreter', $Data);

    }


    /**
     * IndexGET
     *
     * Index view of admin dashboard
     * 
     * @return void
     */
    function IndexGET() {

        $this->CheckLogin(); // Check login

        $Data = [
            'Title' => 'پنل مدیر',
        ];

        $this->Render('Index', $Data);

    }


    

}