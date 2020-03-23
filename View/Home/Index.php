<?php

?>
<!--PAYLOAD_CONTENT_END-->

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#"><?php echo _AppName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo _Root ?>">خانه <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">RSS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">اپلیکیشن (به زودی)</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
<?php
// Slider posts
$i = 0;
foreach ($Data['Model'] as $item)
{
    if ($item['Type'] != "Slider")
        continue;
    $i++;
?>
    <div class="carousel-item <?php echo $i == 1 ? "active" : "" ?>">
        <img src="<?php echo $item['FileName']?>" alt="<?php echo $item['Title']?>" srcset="" class="bd-placeholder-img" height="100%">
        <div class="container">
            <div class="carousel-caption">
                <h1><?php echo $item['Title']?></h1>
                <p><a class="btn btn-lg btn-primary" href="<?php echo _Root . 'Home/View/' . $item['Id'] ?>" role="button">مطالعه بیشتر</a></p>
            </div>
        </div>
    </div>
<?php
}
?>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container marketing">
    <div class="row">
<?php
foreach ($Data['Model'] as $item)
{
    if ($item['Type'] != "Card")
        continue;
?>
<div class="col-lg-4">
    <img width="140" height="140" src="<?php echo $item['FileName']?>" alt="<?php echo $item['Title']?>" srcset="" class="bd-placeholder-img rounded-circle">
    <h2><?php echo $item['Title'] ?></h2>
    <p><?php
    $AllowedCharsLimit = 60;
    if(strlen($item['Abstract']) > $AllowedCharsLimit)
      echo substr($item['Abstract'], 0, $AllowedCharsLimit)."...";
    else
      echo $item['Abstract'];
    ?></p>
    <span class="sm"><?php echo $item['Submit'] ?></span>
    <p><a class="btn btn-secondary" href="<?php echo _Root . 'Home/View/' . $item['Id'] ?>" role="button">ادامه مطلب</a></p>
</div>
<?php
}
?>
    </div>
<?php
// Row posts
$row_index = 1;
foreach ($Data['Model'] as $item)
{
    if ($item['Type'] != "Row")
        continue;
    $row_index++;
?>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-7 <?php echo $row_index % 2 == 0 ? "order-md-1" : "order-md-3"?>">
            <h2 class="featurette-heading"><?php echo $item['Title'] ?></h2>
            <p class="lead"><?php echo $item['Abstract'] ?></p>
        </div>
        <div class="col-md-5 order-md-2">
            <img src="<?php echo $item['FileName']?>" alt="<?php echo $item['Title']?>" srcset="" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500">
        </div>
    </div>
<?php
}
?>
</div>