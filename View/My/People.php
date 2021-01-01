<table id="posts" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>شناسه</th>
            <th>نام کاربری</th>
            <th>کلمه‌ی عبور</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($Data['Model'] as $item)
{
?>
        <tr>
            <td>
            <?php echo $item['Id'] ?>
            </td>
            <td>
            <?php echo $item['Username'] ?>
            </td>
            <td>
            <a class="btn btn-sm btn-primary" href="<?php echo _Root . 'My/Person/' . $item['Id'] ?>">تغییر کلمه‌ی عبور</a>
            </td>
        </tr>
<?php
}
?>
    </tbody>
    <tfoot>
        <tr>
            <th>شناسه</th>
            <th>نام کاربری</th>
            <th>کلمه‌ی عبور</th>
        </tr>
    </tfoot>
</table>