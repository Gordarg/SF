<table id="posts" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>مدیریت</th>
            <th>عنوان</th>
            <th>فایل</th>
            <th>تاریخ ارسال</th>
            <th>خلاصه</th>
            <th>نویسنده</th>
            <th>کامنت‌ها</th>
            <th>بازدید‌ها</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($Data['Model'] as $item)
{
?>
        <tr>
            <td>
            <a href="<?php echo _Root . "Admin/WritePost/" . $item['Id'] ?>" class="btn btn-sm btn-warning">ویرایش</a>
            <a href="<?php echo _Root . "Admin/WritePost/" . $item['Id'] ?>" class="btn btn-sm btn-danger">حذف</a>
            </td>
            <td>
            <?php echo $item['Title'] ?>
            </td>
            <td><a href="<?php echo _Root . _UploadDirectory . $item['FileName'] ?>">نمایش</a></td>
            <td>
            <?php
            $Year = $item['Year'];
            $Month = $item['Month'];
            $Day = $item['Day'];
            $ShamsiDate = gregorian_to_jalali($Year, $Month, $Day, '/');
            echo  $ShamsiDate
            ?>
            </td>
            <td>
            <span title="<?php echo $item['Abstract'] ?>" data-toggle="tooltip">
            👆
            </span> 
            </td>
            <td>ادمین</td>
            <td>15</td>
            <td>600</td>
        </tr>
<?php
}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>مدیریت</th>
            <th>عنوان</th>
            <th>فایل</th>
            <th>تاریخ ارسال</th>
            <th>خلاصه</th>
            <th>نویسنده</th>
            <th>کامنت‌ها</th>
            <th>بازدید‌ها</th>
        </tr>
    </tfoot>
</table>