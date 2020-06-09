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
            <a class="nav-link" type="application/rss+xml" href="<?php echo _Root . "RSS" ?>">نسخه‌ی XML</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


<pre class="container">
    <code class="xml text-wrap"><?php
    echo '  '.$Data['Result'];
    ?></code>
</pre>


<script src="<?php echo _Root .  'static/js/feed.js' ?>"></script>