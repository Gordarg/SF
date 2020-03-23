<section class="jumbotron text-center self-align-center">
    <div class="container">
        <h1 class="jumbotron-heading">تصاویر</h1>
        <p class="lead text-muted">مدیای سایت در این صفحه آپلود و نگهداری می‌شوند.</p>
        <p>

        <form class="form" method="post" enctype="multipart/form-data" action="<?php echo _Root . 'Admin/Album/' ?>">
            <div >
                <input type="file" class="form-control ezdz_" name="FileInput" id="FileInput">
            </div>
    
            <input type="submit" value="آپلود" name="Submit" class="btn btn-primary my-2" />
        </form>
        </p>
    </div>
    </section>

    <div class="album py-5 bg-light">
    <div class="container">

    <div class="row">
<?php
foreach ($Data['Model'] as $item)
{
?>
        <div class="col-md-4 min-width-jeghel">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="<?php echo _Root . _UploadDirectory . $item['FileName'] ?>" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text text-left"><?php echo $item['FileName'] ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                    <form
                    onsubmit="return validate(this);"
                    class="btn-group"
                    method="post"
                    action="<?php echo _Root . 'Admin/Album/' . $item['Id'] ?>"
                    >
                        <a class="btn btn-sm btn-outline-secondary" href="<?php echo _Root . _UploadDirectory . $item['FileName'] ?>" target="_blank">دانلود</a>
                        <button type="submit" name="Delete" class="text-danger btn btn-sm btn-outline-secondary">حذف</button>
                    </form>
                    <small class="text-muted"><?php echo $item['Submit'] ?></small>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?>
    </div>
</div>

<script>
function validate(form) {
    if(false) {
        alert('این پیغام را هرگز نخواهید دید! یک شوخی برنامه نویسی کوچک است.');
        return false;
    }
    else {
        return confirm('آیا از حذف این فایل اطمینان دارید؟');
    }
}
</script>