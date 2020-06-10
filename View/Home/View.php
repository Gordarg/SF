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
        <!-- <li class="nav-item">
          <a class="nav-link" href="about.html">درباره</a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url('<?php echo _Root . 'Post/Download/' . $Data['Model']['Language'] . '/' . $Data['Model']['MasterId'] ?>')">
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

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
      <span class="text-muted">
      <?php echo $Data['Model']['Username'] ?>
      </span>
      <p>
      <?php echo $Data['Model']['Body'] ?>
      </p>
    </div>
  </div>
</div>

<script src="<?php echo _Root ?>static/js/view.js"></script>