<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head >
  <link   rel="StyleSheet" href="./database/open_iqc/css/styles.css" type="text/css">
  <title>Image Qualty Control</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
  <script type="text/javascript" src="java/js/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="java/js/highcharts.js" ></script>
  <script type="text/javascript" src="java/js/themes/skies.js"></script>
{literal}
<script type="text/javascript">
	var chart;
			$(document).ready(function() {
				var options = {
					chart: {
						renderTo: 'container',
                                    zoomType: 'x',
						defaultSeriesType: 'line',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: 'Hourly Visits',
						x: -20 //center
					},
					subtitle: {
						text: '',
						x: -20
					},
					xAxis: {
						type: 'datetime',
						tickInterval: 3600 * 1000, // one hour
						tickWidth: 0,
						gridLineWidth: 1,
                                    dateTimeLabelFormats : {
                                      day : '%H'
                                    },
                                    labels: {
							align: 'center',
							x: -3,
							y: 20,
							formatter: function() {
                                                return Highcharts.dateFormat('%l%p', this.value);
							}
						}
					},
                              rangeSelector: {
	    	                    enabled: true
	                        }, 
					yAxis: {
						title: {
							text: 'Visits'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				               return Highcharts.dateFormat('%l %p %d %B %Y', this.x) +': <b>'+ this.y + '</b>';
                                    }
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					series: [{marker: {}},{marker: {}},{marker: {}},{marker: {}},{marker: {}}]
				}
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('data.php', null, function(tsv) {
					var lines = [];
					traffica = [];
                              trafficb = [];
                              trafficc = [];
                              trafficd = [];
                              traffice = [];
                              
					try {
						// split the data return into lines and parse them
						tsv = tsv.split(/\n/g);
						jQuery.each(tsv, function(i, line) {
							
                                          line = line.split(/\t/);
							switch(i)
                                          {
                                          case 0:
                                            options.series[0].name = line[0];
                                            options.series[1].name = line[1];
                                            options.series[2].name = line[2];
                                            options.series[3].name = line[3];
                                            options.series[4].name = line[4];  
                                            break;
                                          case 1:
                                            options.series[0].color = line[0];
                                            options.series[1].color = line[1];
                                            options.series[2].color = line[2];
                                            options.series[3].color = line[3];
                                            options.series[4].color = line[4];
                                            break;
                                          case 2:
                                            options.series[0].dashStyle = line[0];
                                            options.series[1].dashStyle = line[1];
                                            options.series[2].dashStyle = line[2];
                                            options.series[3].dashStyle = line[3];
                                            options.series[4].dashStyle = line[4];
                                            break;
                                          case 3:
                                            options.series[0].marker.enabled = 0;
                                            options.series[1].marker.enabled = 0;
                                            options.series[2].marker.enabled = 1;
                                            options.series[3].marker.enabled = 0;
                                            options.series[4].marker.enabled = 0;
                                            break;
                                          case 4:
                                            options.series[0].marker.symbol = line[0];
                                            options.series[1].marker.symbol = line[1];
                                            options.series[2].marker.symbol = line[2];
                                            options.series[3].marker.symbol = line[3];
                                            options.series[4].marker.symbol = line[4];
                                            break;



                                          default: 
                                            //date = Date.parse(line[0] +' UTC');
                                            //date = Date(line[0][0], line[0][1] - 1, line[0][2], line[0][3], line[0][4], line[0][5]);
                                            date = parseInt(line[0])*1000;
							  window.alert(date);
                                            traffica.push([
								date,
								parseFloat(line[1].replace('',''))
							  ]);
                                            trafficb.push([
								date,
								parseFloat(line[2].replace('',''))
							  ]);
                                            trafficc.push([
								date, 
                                                parseFloat(line[3].replace('',''))
              		                    ]);
                                            trafficd.push([
								date,
								parseFloat(line[4].replace('',''))
							  ]);
                                            traffice.push([
								date,
								parseFloat(line[5].replace('',''))
							  ]);
//parseInt(line[5].replace('.', ''), 10)

                                          }
						});
					} catch (e) {  }
					options.series[0].data = traffica;
                              options.series[1].data = trafficb;
                              options.series[2].data = trafficc;
                              options.series[3].data = trafficd;
                              options.series[4].data = traffice;

					chart = new Highcharts.Chart(options);
				});
			});
</script>
{/literal}


</head>
<body bgcolor="#f3f6ff">

<div id="container" style="width: 100%; height: 80%; margin: 0 auto"></div>   
</body>
</html>
