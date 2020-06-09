<?php

?>
<!--PAYLOAD_CONTENT_END-->

 <!-- Navigation -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?php echo _Root ?>"><?php echo _AppName ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo _Root ?>">خانه
              <span class="sr-only">*</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo _Root . 'Authentication/Login' ?>">ورود به سیستم</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo _Root . 'docs' ?>">مستندات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo _Root . 'Home/Feed' ?>">RSS</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

<?php /* TODO: If search
        <h1 class="my-4">عنوان ۱
          <small>زیر متن</small>
        </h1>
        */ ?>

        <?php
// Slider posts
foreach ($Data['Model'] as $item)
{
?>
        <!-- Blog Post -->
        <div class="card mb-4">
          <img class="card-img-top" src="<?php echo _Root . 'Post/Download/' . $item['Language'] . '/' . $item['MasterID'] ?>" alt="Card image cap">
          <div class="card-body">
            <h2 class="card-title"><?php echo $item['Title'] ?></h2>
            <p class="card-text"><?php echo $item['Body'] ?></p>
            <a href="#" class="btn btn-primary">بیشتر &larr;</a>
          </div>
          <div class="card-footer text-muted">
            <?php 
              $Year = $item['Year'];
              $Month = $item['Month'];
              $Day = $item['Day'];
              $ShamsiDate = gregorian_to_jalali($Year, $Month, $Day, '/');
              echo  $ShamsiDate
            ?>
            <a href="#"><?php echo $item['Username'] ?></a>
          </div>
        </div>
<?php
}
?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item disabled">
            <a class="page-link" href="#">&rarr; قدیمی‌تر</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">جدید‌تر &larr;</a>
          </li>
        </ul>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">Web Design</a>
                  </li>
                  <li>
                    <a href="#">HTML</a>
                  </li>
                  <li>
                    <a href="#">Freebies</a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <li>
                    <a href="#">JavaScript</a>
                  </li>
                  <li>
                    <a href="#">CSS</a>
                  </li>
                  <li>
                    <a href="#">Tutorials</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Side Widget</h5>
          <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

