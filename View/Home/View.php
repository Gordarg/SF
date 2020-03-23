<link rel="stylesheet" href="<?php echo _Root ?>static/css/view.css">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top is-fixed is-visible" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="index.html"><?php echo _AppName ?></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      ☰
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item clearfix">
          <a class="btn btn-primary float-right" href="<?php echo _Root ?>">خانه →</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.html">درباره</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="post.html">همراه شوید</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">ارتباط با ما</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo $Data['Model']['FileName']?>')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1 class="display-1"><?php echo $Data['Model']['Title'] ?></h1>
          <small class="text-muted subheading">
          <?php
            $Year = $Data['Model']['Year'];
            $Month = $Data['Model']['Month'];
            $Day = $Data['Model']['Day'];
            $ShamsiDate = gregorian_to_jalali($Year, $Month, $Day, '/');
            echo  $ShamsiDate
          ?>
          </small>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Message Box -->
<?php if (isset($Data["Message"]))
{
?>

<!-- Flexbox container for aligning the toasts -->
<div style="position: fixed; z-index:2; bottom: 10%; right: 10%; min-width: 300px;" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">

  <!-- Then put toasts within -->
  <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>نظر دهی</strong>
      <small>چند لحظه پیش</small>
    </div>
    <div class="toast-body">
        <?php echo $Data["Message"] ?>
    </div>
  </div>
</div>


<script>
$('.toast').toast({
            delay: 30000
        });
$('.toast').toast('show');
</script>
<?php
}
?>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
      <span class="text-muted">
      <?php echo $Data['Model']['Abstract'] ?>
      </span>
      <p>
      <?php echo $Data['Model']['Body'] ?>
      </p>
    </div>
  </div>
  
  <hr>

  <div class="row text-right">
    <form class="form col-lg-4 col-md-5 mx-auto p-4"
    method="post" action="<?php echo _Root . "Home/Comment/" . $Data['Model']['Id'] ?>">
      <h1 class="h3 mb-3 font-weight-normal text-center">ثبت پیام</h1>
      
      <label for="NameInput" >نام شما</label>
      <input type="text" name="NameInput" id="NameInput" class="form-control m-2" placeholder="این نام نمایش داده خواهد شد" required>

      <label for="EMailInput" >نشانی پست الکترونیک<span class="text-muted"> (محفوظ است)</span></label>
      <input type="email" name="EMailInput" id="EMailInput" class="form-control m-2" placeholder="نشانی پست الکترونیک خود را وارد نمایید" required>

      <label for="BodyInput">پیام</label>
      <textarea name="BodyInput" id="BodyInput" class="form-control m-2" placeholder="متن پیام خود را وارد نمایید">
      </textarea>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="IsPublicInput" value="true" checked> نمایش داده شود
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">ثبت دیدگاه</button>
    </form>
    <ul class="col-lg-8 min-width-jeghel col-md-5 mx-auto">
      <?php foreach($Data['CommentsModel'] as $item)
      {
      ?>
      <li class="speech-bubble p-4 m-4">
        <span><?php echo $item['Name'] ?></span>
        <span class="text-muted"><?php
            $Year = $item['Year'];
            $Month = $item['Month'];
            $Day = $item['Day'];
            $ShamsiDate = gregorian_to_jalali($Year, $Month, $Day, '/');
            echo  $ShamsiDate
            ?></span>
        <p><?php echo $item['Body'] ?></p>
      </li>
      <?php } ?>
      <!-- <li class="speech-bubble-left p-4 m-4">
        <span class="text-light">ادمین</span>
        <p>از شما ممنونیم</p>
      </li> -->
    </ul>
  </div>
</div>


<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <ul class="list-inline text-center">
          <li class="list-inline-item">
            <a href="#">
              <span class="fa-stack fa-lg">
                اشتراک در فیسبوک
              </span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#">
              <span class="fa-stack fa-lg">
                ارسال در توییتر
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="<?php echo _Root ?>static/js/view.js"></script>