<link href="<?php echo _Root ?>static/css/login.css" rel="stylesheet">

<?php
// Message Modal
if (isset($Data['Message'])) {
?>
<div class="modal show" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">پیغامی دارید!</h5>
      </div>
      <div class="modal-body">
      <?php echo $Data['Message'] ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">بستن</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(window).on('load',function(){
        $('.modal').modal('show');
    });
</script>
<?php
}
?>


<a class="httpauth" id="basic" href="<?php echo _Root . 'Authentication/Login' ?>">ورود به سیستم</a>

<script src="<?php echo _Root . 'static/js/login.js' ?>"></script>