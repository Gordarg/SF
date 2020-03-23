<?php

$Title = $Abstract = $Body = $Type = $FileName = '';

if (isset($Data['Model']))
{
    $Title = $Data['Model']['Title'];
    $Abstract = $Data['Model']['Abstract'];
    $Body = $Data['Model']['Body'];
    $Type = $Data['Model']['Type'];
    $FileName = $Data['Model']['FileName'];
}

?>
<form class="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="TitleInput">عنوان</label>
        <input type="text" class="form-control" name="TitleInput"
        id="TitleInput" placeholder="عنوان پست را وارد کنید"
        value="<?php echo $Title ?>"
        >
    </div>

    <div class="form-group">
        <label for="AbstractInput">خلاصه</label>
        <textarea data-toggle="tooltip" title="این متن زیر عنوان قرار می‌گیرد و اولین برخورد مخاطب بعد از عنوان با متن است"
        class="form-control" name="AbstractInput" id="AbstractInput"><?php echo $Abstract ?></textarea>
    </div>

    <div class="form-group">
        <label for="BodyInput">متن</label>
        <input type="text" class="form-control tinymce" name="BodyInput" id="BodyInput"
        value="<?php echo $Body ?>">
    </div>

    <div class="form-group">
        <label for="FileNameInput">فایل بنر</label>
        <input type="text" class="form-control" name="FileNameInput"
        id="FileNameInput" placeholder="آدرس فایل را وارد کنید"
        value="<?php echo $FileName ?>">
    </div>

    <div class="form-group">
        <label for="TypeInput">تیپ</label>
        <select class="form-control" name="TypeInput" id="TypeInput">
            <option value="Card" <?php echo $Type=="Card"?"selected=\"selected\"" : "" ?>>کارت</option>
            <option value="Slider" <?php echo $Type=="Slider"?"selected=\"selected\"" : "" ?>>اسلایدر</option>
            <option value="Row" <?php echo $Type=="Row"?"selected=\"selected\"" : "" ?>>ردیف</option>
        </select>
    </div>

<?php
if (isset($Data['Model']))
{
?>
    <button type="submit" class="btn btn-warning m-2" name="Update">ثبت تغییرات</button>
    <button type="submit" class="btn btn-danger m-2" name="Delete">حذف پست</button>

<?php
} else {
?>
    <button type="submit" class="btn btn-primary m-2" name="Insert">ارسال پست</button>

<?php
}
?>
</form>