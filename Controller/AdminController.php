<?php

/**
 * 
 * Controller class for admin panel
 * 
 */
class AdminController extends Controller {

    /**
     * IndexGET
     *
     * Index view of admin dashboard
     * 
     * @return void
     */
    function IndexGET() {

        $this->CheckAuth($_COOKIE); // Check login

        $Data = [
            'Title' => 'پنل مدیر',
        ];

        $this->Render('Index', $Data);

    }


    /**
     * UsersGET
     *
     * List the posts
     * 
     * @return void
     */
    function UsersGET() {

        $this->CheckAuth($_COOKIE); // Check login

        // Ask database for data
        $Model = $this->CallModel("User");
        $Rows = $Model->GetAllUsers();

        // Package the response
        $Data = [
            'Title' => 'مدیریت کاربر‌ها',
            'Model' => $Rows
        ];
        
        // Render the view
        $this->Render('Users', $Data);

        
    }


    /**
     * UserGET
     *
     * Get a user details and managment stuff
     * 
     * @return void
     */
    function UserGET($Id = 0) {

        $this->CheckAuth($_COOKIE); // Check login


        // Check if Id is passed to function
        if ($Id != 0)
        {
            $Model = $this->CallModel("User");
            $Rows = $Model->GetUserById([
                'Id' => $Id,
            ]);

            if (count($Rows) == 0)
                goto the_notfound;

            $Row = $Rows[0];

            $Data = [
                'Title' => 'مدیریت کاربر',
                'Model' => $Row
            ];
            
            $this->Render('User', $Data);

        }
        // If it was insert
        else
        {
            the_notfound: // A goto (evil) stuff // Just a programming fun.
            throw new NotFoundException("شناسه‌ی کاربری مورد نظر پیدا نشد");
        }
    }


    /**
     * UserPOST
     *
     * Update user details
     * 
     * @return void
     */
    function UserPOST($Id = 0) {
        
        $this->CheckAuth($_COOKIE); // Check login

        // Check if Id is passed to the function
        if ($Id != 0)
        {
            // Call the model
            $Model = $this->CallModel("User");

            // Initialy set message to String.Empty
            $Message = '';

            // Check if user exist from parameters
            $Rows = $Model->GetUserById([
                'Id' => $Id
            ]);
            if (count($Rows) > 0)
            {

                // Check if new password and it's confirm match
                if ($_POST['NewPassInput'] == $_POST['ConfirmPassInput'])
                {

                    // Check former password
                    $CheckLogin = $Model->CheckLogin([
                        'Email' => $Rows[0]['Email'],
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
                $this->Render('User', $Data);

                // Don't allow program to go to the next lines
                return;
            }
                
        }

        // If user id did not exist in database or sent as paramter to this method
        throw new NotFoundException("شناسه‌ی کاربری مورد نظر پیدا نشد");
    }


    /**
     * PostsGET
     *
     * List the posts
     * 
     * @return void
     */
    function PostsGET($Status = '') {

        $this->CheckAuth($_COOKIE); // Check login

        // Ask database for data
        $Model = $this->CallModel("Post");
        $Rows = $Model->GetAllPosts();

        // Make it ready for display
        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['FileName'] = utf8_decode($Rows[$i]['FileName']);
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            $Rows[$i]['Abstract'] = utf8_decode($Rows[$i]['Abstract']);
        }

        // Package the response
        $Data = [
            'Title' => 'مدیریت پست‌ها',
            'Model' => $Rows
        ];

        // If there was a successful redirect from WritePost page
        if ($Status == 'Success')
            $Data['Message'] = 'کار انجام شد. خیالت راحت!';
        
        // Render the view
        $this->Render('Posts', $Data);

        
    }


    /**
     * CommentsGET
     *
     * List the comments
     * 
     * @return void
     */
    function CommentsGET($Status = '') {

        $this->CheckAuth($_COOKIE); // Check login

        // Ask database for data
        $Model = $this->CallModel("Comment");
        $Rows = $Model->GetAllComments();

        // Make it ready for display
        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            $Rows[$i]['Name'] = utf8_decode($Rows[$i]['Name']);
            $Rows[$i]['Body'] = utf8_decode($Rows[$i]['Body']);
        }

        // Package the response
        $Data = [
            'Title' => 'مدیریت نظر‌ها',
            'Model' => $Rows
        ];

        // If there was a successful redirect from manage comment page
        if ($Status == 'Success')
            $Data['Message'] = 'کار انجام شد. خیالت راحت!';
        
        // Render the view
        $this->Render('Comments', $Data);

        
    }


    /**
     * CommentGET
     *
     * Manage the comment
     * 
     * @return void
     */
    function CommentGET($Id = 0) {

        $this->CheckAuth($_COOKIE); // Check login

        // If it was update or delete
        if ($Id != 0)
        {
            $Model = $this->CallModel("Comment");
            $Row = $Model->GetCommentById([
                'Id' => $Id,
            ])[0];

            // Ready for display
            $Row['Title'] = utf8_decode($Row['Title']);
            $Row['Name'] = utf8_decode($Row['Name']);
            $Row['Body'] = utf8_decode($Row['Body']);

            // Prepare data
            $Data = [
                'Title' => 'مدیریت نظر',
                'Model' => $Row
            ];

            // Render the view
            $this->Render('Comment', $Data);

            // Successfully stop the function
            return;
        }
        
        throw new NotFoundException("شناسه نظر یافت نشد");
    }

    /**
     * CommentPOST
     *
     * Update the comment details
     * 
     * @return void
     */
    function CommentPOST($Id = 0) {

        $this->CheckAuth($_COOKIE); // Check login

        // If it was update or delete
        if ($Id != 0)
        {
            $Model = $this->CallModel("Comment");

            // Update the comment
            $Response = $Model->UpdateComment([
                'Id' => $Id,
                'IsDeleted' => isset($_POST['IsDeletedInput']),
                'IsVisible' => isset($_POST['IsVisibleInput']),
            ]);

            // Fetch data again
            $Row = $Model->GetCommentById([
                'Id' => $Id,
            ])[0];

            // Ready for display
            $Row['Title'] = utf8_decode($Row['Title']);
            $Row['Name'] = utf8_decode($Row['Name']);
            $Row['Body'] = utf8_decode($Row['Body']);

            // Prepare data
            $Data = [
                'Title' => 'مدیریت نظر',
                'Model' => $Row
            ];

            // Render the view
            $this->Render('Comment', $Data);

            // Successfully stop the function
            return;
        }
        
        throw new NotFoundException("شناسه نظر یافت نشد");
    }

    /**
     * WritePostGET
     *
     * Create new Post
     * 
     * @return void
     */
    function WritePostGET($Id = 0) {

        $this->CheckAuth($_COOKIE); // Check login

        // If it was update or delete
        if ($Id != 0)
        {
            $Model = $this->CallModel("Post");
            $Row = $Model->GetPostById([
                'Id' => $Id,
            ])[0];

            // Ready for display
            $Row['Title'] = utf8_decode($Row['Title']);
            $Row['Abstract'] = utf8_decode($Row['Abstract']);
            $Row['Body'] = utf8_decode($Row['Body']);

            $Data = [
                'Title' => 'ویرایش پست',
                'Model' => $Row
            ];   
        }
        // If it was insert
        else
        {
            $Data = [
                'Title' => 'پست جدید',
            ];
        }

        $this->Render('WritePost', $Data);
        
    }

    /**
     * WritePostPOST
     *
     * Insert a new post!
     * 
     * @return void
     */
    function WritePostPOST($Id = 0) {
        
        $this->CheckAuth($_COOKIE); // Check login

        // Ask database to be ready
        $Model = $this->CallModel("Post");

        // Make values ready for insert or update
        $Values = [
            'Title' => utf8_encode($_POST['TitleInput']),
            'Body' => utf8_encode(htmlspecialchars($_POST['BodyInput'])),
            'Abstract' => utf8_encode($_POST['AbstractInput']),
            'Type' => $_POST['TypeInput'],
            'FileName' => $_POST['FileNameInput']
        ];

        // If it was update or delete
        if ($Id != 0)
        {
            // If it was delete
            if (isset($_POST['Delete']))
            {
                $Response = $Model->DeletePost([
                    'Id' => $Id
                ]);

                // Redirect to posts management
                if ($Response)
                {
                    $this->RedirectResponse(_Root . "Admin/Posts/Success");
                    return;
                }
            }
            // If it was update
            else if (isset($_POST['Update']))
            {
                $Values['Id'] = $Id;

                $Response = $Model->UpdatePost($Values);

                // Redirect to posts management
                if ($Response)
                {
                    $this->RedirectResponse(_Root . "Admin/Posts/Success");
                    return;
                }
            }


            // Decode for display
            $Values['Title'] = utf8_decode($Values['Title']);
            $Values['Abstract'] = utf8_decode($Values['Abstract']);
            $Values['Body'] = utf8_decode($Values['Body']);

            $Data = [
                'Title' => 'ویرایش پست',
                'Message' => $Response ? 'یه اتفاقی افتاده که خودمون هم نمی‌دونیم چیه...' : 'خطای پایگاه داده'
            ];

            $this->Render('WritePost', $Data);
        }
        // If it was insert
        else
        {
            $Response = $Model->InsertPost($Values);

            // Redirect to posts management
            $this->RedirectResponse(_Root . "Admin/Posts/Success");
        }


    }


    /**
     * AlbumGET
     *
     * Show gallery albums
     * 
     * @return void
     */
    function AlbumGET($Status = '') {
        
        $this->CheckAuth($_COOKIE); // Check login

        $Model = $this->CallModel("File");
        $Rows = $Model->GetFiles();

        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['FileName'] = utf8_decode($Rows[$i]['FileName']);
        }

        $Data = [
            'Title' => "آلبوم",
            'Model' => $Rows
        ];

        // If there was a successful redirect from WritePost page
        if ($Status == 'Success')
            $Data['Message'] = 'کار انجام شد. خیالت راحت!';
        else if ($Status == 'Failure')
            $Data['Message'] = 'کار انجام نشد. یه چیزی با عقل جور در نمیاد!';
        
        $this->Render('Album', $Data);
    }

    /**
     * AlbumPOST
     *
     * Posts a file (these days images) to gallery
     * Also handles delete operation
     * 
     * @return void
     */
    function AlbumPOST($Id = 0) {
        
        $this->CheckAuth($_COOKIE); // Check login

        // If it was delete
        if ($Id) {

            $Model = $this->CallModel("File");
            $Values['Id'] = $Id;

            $Response = false;

            // Get files from db to check existance
            $Files = $Model->GetFile($Values);

            if (count($Files) > 0)
                // Delete the file from db
                $Response = $Model->DeleteFile($Values);

            // If successfully deleted from db
            if ($Response)
            {

                // Get the filename to delete from filesystem
                $FileName = $Files[0]['FileName'];
                // Delete the file form disk
                $TargetDirectory = _UploadDirectory;
                if (unlink($TargetDirectory.$FileName)) {
                    // Everything ok; redirect.
                    $this->RedirectResponse(_Root . "Admin/Album/Success");
                    return;
                }
            }
            // Something was wrong
            $this->RedirectResponse(_Root . "Admin/Album/Failure");
            return;
        }

        // else if wasn't delete

        $InputName = "FileInput";

        // File upload path and extension
        $TargetDirectory = _UploadDirectory;
        $FileName = basename($_FILES[$InputName]["name"]);
        $FileType = pathinfo( $TargetDirectory . $FileName,PATHINFO_EXTENSION);
        $FileCounter = 0;

        // Check the HTTP request
        if(isset($_POST["Submit"]) && !empty($_FILES[$InputName]["name"])) {
            // Allow certain file formats
            $AllowedTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($FileType, $AllowedTypes)) {
                // Check if file with same name exist
                while (file_exists($TargetDirectory . $FileName)) {
                    $FileCounter++;
                    $FileName = pathinfo($FileName, PATHINFO_FILENAME) . ( $FileCounter ? " _rep" : "" ) . "." . $FileType;
                }
                // Add counter to file name
                // Upload file to server
                if(move_uploaded_file($_FILES[$InputName]["tmp_name"], // From
                    $TargetDirectory . $FileName // To
                    )) {
                    // Insert image file name into database
                    
                    
                    $Model = $this->CallModel("File");

                    $Response = $Model->InsertNewFile([
                        'FileName' => utf8_encode($FileName)
                    ]);

                    $Message = $Response ? "تصویر با موفقیت در پایگاه داده ثبت شد" : "خطای پایگاه داده";

                    if ($Response)
                    {
                        $Rows = $Model->GetFiles();
                
                        for ($i = 0 ; $i < count($Rows) ; $i++)
                        {
                            $Rows[$i]['FileName'] = utf8_decode($Rows[$i]['FileName']);
                        }
                
                        $Data = [
                            'Title' => "آلبوم",
                            'Model' => $Rows
                        ];
                
                        $this->Render('Album', $Data);

                        return $FileName;
                    }


                }
                else {
                    $Message = "خطا در بارگزاری فایل بر روی سرور";
                }
            }
            else {
                $Message = 'فرمت‌های مجاز برای ارسال فایل: JPG، JPEG، PNG، GIF، و PDF هستند.';
            }
        }
        else {
            $Message = 'لطفا یک فایل را برای ارسال انتخاب نمایید.';
        }

        // Postback data
        $Data = [
            'Title' => 'فایل‌ها',
            'Message' => $Message
        ];
        // Render the view
        $this->Render('Album', $Data);


    }


}