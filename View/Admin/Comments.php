<table id="posts" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>مشاهده</th>
            <th>ایمیل فرستنده</th>
            <th>نام فرستنده</th>
            <th>پست</th>
            <th>پیام</th>
            <th>تاریخ</th>
            <th>وضعیت نمایش</th>
            <th>وضعیت انتشار</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($Data['Model'] as $item)
{
?>
    <tr>
        <td>
        <a href="<?php echo _Root . "Admin/Comment/" . $item['Id'] ?>" class="btn btn-sm btn-success">مشاهده</a>
        </td>
        <td>
        <?php echo $item['EMail'] ?>
        </td>
        <td>
        <?php echo $item['Name'] ?>
        </td>
        <td>
        <span title="<?php echo $item['Title'] ?>" data-toggle="tooltip">
        👆
        </span> 
        </td>
        <td>
        <?php echo $item['Body'] ?>
        </td>
        <td>ادمین</td>
        <td class="text-center">
        <?php echo $item['IsVisible'] ? "<span class=\"text-success\">✓</span>" : "نمایش داده نشود" ?>
        </td>
        <td class="text-center">
        <?php echo $item['IsPublic'] ? "<span class=\"text-success\">✓</span>" : "پیام خصوصی" ?>
        </td>
    </tr>
<?php
}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>مشاهده</th>
            <th>ایمیل فرستنده</th>
            <th>نام فرستنده</th>
            <th>پست</th>
            <th>پیام</th>
            <th>تاریخ</th>
            <th>وضعیت نمایش</th>
            <th>وضعیت انتشار</th>
        </tr>
    </tfoot>
</table>