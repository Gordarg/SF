<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><?php echo _AppName ?></a>
    <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a class="nav-link logout" href="<?php echo _Root . 'Authentication/Logout' ?>">خروج</a>
    </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>مدیریت</span>
                <a class="d-flex align-items-center text-muted" href="#">
                </a>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo _Root . 'Admin' ?>">
                        داشبورد
                    </a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo _Root . 'Admin/Interpreter#Tickets' ?>">
                    تیکت‌ها
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo _Root . 'Admin/Interpreter#EMails' ?>">
                    ایمیل‌ها
                </a>
                </li> -->
                <li class="nav-item">
                <a class="nav-link" href="<?php echo _Root . 'Admin/Interpreter#Post' ?>">
                    پست جدید
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="<?php echo _Root . 'Admin/Interpreter#Posts' ?>">
                    پست‌ها
                </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>مدیر سیستم</span>
                <a class="d-flex align-items-center text-muted" href="#">
                </a>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                <a class="nav-link" href="<?php echo _Root . 'Admin/People' ?>">
                    مدیریت کاربر‌ها
                </a>
                </li>
            </ul>


            
        </div>
    </nav>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <!--VIEW_CONTENT-->
    </main>
    </div>
</div>
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

<script src="<?php echo _Root ?>static/js/dashboard.js"></script>
<script type="text/javascript">
    function ToggleSidebar(){
        // Show and hide sidebar
        $('#sidebar').toggleClass('active');
    };
    $(document).ready(function(){
        // Show hints on hover
        $('[data-toggle="tooltip"]').tooltip();
        // Alow drag 'n drop
        $('[type="file"].ezdz').ezdz(); 
        // Standard tables
        $('table').DataTable();
        // Beautify inputs
        $('input, select').addClass("form-control");
    });
</script>
<script src="<?php echo _Root ?>static/js/login.js"></script>