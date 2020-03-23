<div class="card mb-4" id="Count">
    <div class="card-header">تعداد نظر‌های ثبت شده</div>
    <div class="card-body">
        <canvas id="myBarChart" width="736" height="294" class="chartjs-render-monitor" style="display: block; width: 736px; height: 294px;"></canvas>
    </div>
</div>

<script>

// ==== Bar Chart ====

var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?php
      foreach ($Data['GroupedCommentCountRows'] as $item)
      {
        echo '"' . $item['WeekNumber'] . '", ';
      }
      ?>],
    datasets: [{
      label: "تعداد کل نظر‌ها",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [<?php
      $max = 0;
      foreach ($Data['GroupedCommentCountRows'] as $item)
      {
        $max = $max > $item['TotalRequests'] ? $max : $item['TotalRequests'];
        echo $item['TotalRequests'] . ', ';
      }
      ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $max ?>,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>