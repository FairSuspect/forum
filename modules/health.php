  <html>
  <head>
  <title> Моё здоровье </title>
  <link rel = stylesheet href = "..\css\health.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'Steps'],
          ['Monday',  1],
          ['Tuesday',  -1],
          ['Wednesday',  1],
          ['Thursday',  -1],
		  ['Friday', 1],
		  ['Saturday', -1],
		  ['Sunday', 1]
        ]);

        var options = {
          title: 'Steps per day',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
	   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
           ['Day', 'Steps'],
          ['Monday',  7650],
          ['Tuesday',  3454],
          ['Wednesday',  9405],
          ['Thursday',  15030],
		  ['Friday', 12431],
		  ['Saturday', 4331],
		  ['Sunday', 2355]
        ]);

        var options = {
          width: 800,
          legend: { position: 'none' },
          chart: {
            title: 'Chess opening moves',
            subtitle: '' },
          axes: {
            x: {
              0: { side: 'top', label: 'Steps per day'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Chill',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
		
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px; z-index: 1;"></div>
	    <div id="top_x_div"  style="width: 800px; height: 600px; "></div>
		 <div id="donutchart" style="width: 900px; height: 500px;"></div>
		<a href="../index.php" style= "position:absolute; font-size: 14; z-index: 99"> Main page </a>
  </body>
</html>