<div class="row justify-content-center">
    <a class="btn btn-primary" href="<?php echo _Root . 'Admin/Comments' ?>">بازگشت →</a>
    <div class="card min-width-jeghel">
    <img src="<?php echo $Data['Model']['FileName']?>" class="card-img-top" alt="<?php echo $Data['Model']['Title']?>">
    <div class="card-body">
        <h5 class="card-title text-center"><?php echo $Data['Model']['Title']?></h5>
        <p class="card-text">
        <?php echo $Data['Model']['Body']?>
        </p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><?php echo $Data['Model']['Name']?></li>
        <li class="list-group-item"><?php echo $Data['Model']['EMail']?></li>
    </ul>
    <form class="card-body form-inline" method="post">
        <button class="btn btn-primary" name="IsVisibleInput" href="<?php echo _Root . 'Admin/Comments' ?>">تایید و نمایش</button>
        <button class="btn btn-danger" name="IsDeletedInput" href="<?php echo _Root . 'Admin/Comments' ?>">حذف</button>
    </form>
    </div>
</div>