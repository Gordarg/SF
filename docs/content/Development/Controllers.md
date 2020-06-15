# A sample controller be like

```
class AdminController extends Controller {
    function WritePostGET() {
        $Data = [
            'Title' => 'پست جدید',
        ];
        $this->Render('WritePost', $Data);
    }
    function WritePostPOST() {
        $Model = $this->CallModel("Post");
        $Response = $Model->InsertWritePost([
            'Title' => $_POST['TitleInput'],
            'Body' => $_POST['BodyInput'],
            'Abstract' => $_POST['AbstractInput'],
        ]);
        $Data = [
            'Title' => 'پست جدید',
            'Message' => $Response ? 'ارسال با موفقیت انجام شد' : 'خطای پایگاه داده',
            'Model' => $Model->GetHomePagePosts()
        ];
        $this->Render('WritePost', $Data);
    }
}
```