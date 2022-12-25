<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Chart using codeigniter and morris.js</title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  </head>
  <body>

    <h2 style="text-align:center">Chart using Codeigniter and Morris.js</h2>
    
    <div id="graph"></div>
    <p style="text-align:center">Tahun</p>
    <script>
        Morris.Bar({
          element: 'graph',
          barGap:4,
          barSizeRatio:0.30,
          preUnits:"%",
          data: <?php echo $car;?>,
          xkey: 'year',
          ykeys: ['purchase','sale', 'profit'],
          labels: ['Purchase','Sale','Profit'],
          barColors:['#f00', '#efff00','#009aff'],
          stacked:true
        });

		Morris.Line({
          element: 'graph',
          barGap:4,
          barSizeRatio:0.30,
          preUnits:"%",
          data: <?php echo $car;?>,
          xkey: 'year',
          ykeys: ['purchase','sale', 'profit'],
          labels: ['Purchase','Sale','Profit'],
          barColors:['#f00', '#efff00','#009aff'],
          stacked:true
        });

		Morris.Pie({
          element: 'graph', // elemnt id html yang di panggil
          barGap:4, 
          barSizeRatio:0.30, // size  width bar yang di tentukan
          preUnits:"%", // menampilkan berdasarkan persantese y bar
          data: <?php echo $car;?>, // data yang sudah di jadikan json
          xkey: 'year', // data yang akan di tampilkan di bagian horisontal x
          ykeys: ['purchase','sale', 'profit'], // data yang di tampilkan sesuikan nama field table database
          labels: ['Purchase','Sale','Profit'], // Label nama yang akan di tampilkan
          barColors:['#f00', '#efff00','#009aff'], //warna data bar yang di tampilkan
          stacked:true
        });
    </script>
  </body>
</html>