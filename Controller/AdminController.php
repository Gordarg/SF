<?php

/**
 * 
 * Controller class for admin panel
 * 
 */
class AdminController extends Controller {

    /**
     * InterpreterGET
     *
     * View that allows lazy client to load the content
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


    /**
     * PeopleGET
     *
     * List the posts
     * 
     * @return void
     */
    function PeopleGET() {

        $this->CheckLogin('admin'); // Check login

        // Ask database for data
        $Model = $this->CallModel("Person");
        $Rows = $Model->GetAllPeople();

        // Package the response
        $Data = [
            'Title' => 'مدیریت کاربر‌ها',
            'Model' => $Rows
        ];
        
        // Render the view
        $this->Render('People', $Data);

        
    }


    /**
     * PersonGET
     *
     * Get a Person details and managment stuff
     * 
     * @return void
     */
    function PersonGET($Id = 0) {

        $this->CheckLogin(); // Check login


        // Check if Id is passed to function
        if ($Id != 0)
        {
            $Model = $this->CallModel("Person");
            $Rows = $Model->GetPersonById([
                'Id' => $Id,
            ]);

            if (count($Rows) == 0)
                goto the_notfound;

            $Row = $Rows[0];

            $Data = [
                'Title' => 'مدیریت کاربر',
                'Model' => $Row
            ];
            
            $this->Render('Person', $Data);

        }
        // If it was insert
        else
        {
            the_notfound: // A goto (evil) stuff // Just a programming fun.
            throw new NotFoundException("شناسه‌ی کاربری مورد نظر پیدا نشد");
        }
    }


    /**
     * PersonPOST
     *
     * Update Person details
     * 
     * @return void
     */
    function PersonPOST($Id = 0) {
        
        $this->CheckLogin(); // Check login

        // Check if Id is passed to the function
        if ($Id != 0)
        {
            // Call the model
            $Model = $this->CallModel("Person");

            // Initialy set message to String.Empty
            $Message = '';

            // Check if Person exist from parameters
            $Rows = $Model->GetPersonById([
                'Id' => $Id
            ]);
            if (count($Rows) > 0)
            {

                // Check if new password and it's confirm match
                if ($_POST['NewPassInput'] == $_POST['ConfirmPassInput'])
                {

                    // Check former password
                    $CheckLogin = $Model->CheckLogin([
                        'Username' => $Rows[0]['Username'],
                        'Password' => (new Cryptography())->Encrypt($_POST['FormerPassInput'])
                    ]);

                    // If former password was correct
                    if (count($CheckLogin) == 1)
                    {
                        
                        // Update the password
                        $Response = $Model->UpdatePassword([
                            'Id' => $Id,
                            'Password' => (new Cryptography())->Encrypt($_POST['NewPassInput'])
                        ]);

                        // Check for database errors
                        $Message = $Response ? 'کلمه‌ی عبور کاربر به روز شد' : 'خطای پایگاه داده';
                    }
                    else
                    {
                        $Message = 'کلمه‌ی عبور پیشین معتبر نیست';
                    }
                }
                else
                {
                    $Message = 'کلمه‌ی عبور جدید با تکرار آن هم‌خوانی ندارد';
                }

                // Get the current record
                $Row = $Rows[0];

                // Return the view
                $Data = [
                    'Title' => 'مدیریت کاربر',
                    'Message' => $Message,
                    'Model' => $Row
                ];
                $this->Render('Person', $Data);

                // Don't allow program to go to the next lines
                return;
            }
                
        }

        // If Person id did not exist in database or sent as paramter to this method
        throw new NotFoundException("شناسه‌ی کاربری مورد نظر پیدا نشد");
    }

}