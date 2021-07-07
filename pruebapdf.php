<?php
require_once("php/Reportes.php");
$reporte = new Reportes();
$sumatotal = 0;
$cli = "Todos los clientes";
$datos = $reporte->getBusqueda($_POST["fecha1"], $_POST["fecha2"], $_POST["cliente"], $_POST["radio"]);
$tfecha="$_POST[fecha1] al $_POST[fecha2]";
$tabla = "<div class='container'><table  class='table table-striped table-hover'><thead><tr><th>Numero</th><th>Fecha de la venta</th><th>Total</th><th>Nombre del cliente</th></tr></thead><tbody>";
$cont = 0;
while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
     if ($_POST["cliente"]!=0) {
          $cli = "$ren[nombre_per] $ren[ap_per]";
     }
     $cont++;
     $tabla .= "<tr id='r$ren[id_tic]'><td>$cont</td><td>$ren[fechaventa_tic]</td><td>$$ren[total_tic].00</td><td>$ren[nombre_per] $ren[ap_per]</td></tr> ";
     $sumatotal += $ren["total_tic"];
}
if ($datos->num_rows <= 0) {
     $tabla .= "<tr><td> <h3> Sin ventas en el dia o rango de dias </h3> </td></tr>";
} else {
     $tipodecompra=$_POST["radio"];
     if ($_POST["radio"]=="ambos") {
          $tipodecompra="Credito y contado";
     }
     if ($_POST["fecha1"]==0 && $_POST["fecha2"]==0) {
          $tfecha =  "dia ".date("Y-m-d");
     }
     $tabla .= "<div class='alert alert-success' role='alert'><h4>Ventas realizadas a: $tipodecompra</h4><h4>Cliente: $cli</h4><h4>Numero de ventas $cont del $tfecha</h4> <h3>Total: $$sumatotal.00 </h3></div>";
}
$tabla .= "</tbody></table></div>";

?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>

<body>
     <div id="micontenedor">
          <?php
          echo $tabla;
          ?>
     </div>
     <script src="dist/html2pdf.bundle.js"></script>
     <script>
          var element = document.getElementById('micontenedor');
          html2pdf().from(element).set({
               margin: 1,
               filename: 'reportedeventas.pdf',
               html2canvas: {
                    scale: 2
               },
               jsPDF: {
                    orientation: 'portrait',
                    unit: 'in',
                    format: 'letter',
                    compressPDF: true
               }
          }).save();

          function sleep(time) {
               return new Promise((resolve) => setTimeout(resolve, time));
          }
          sleep(2000).then(() => {
               window.close();
          });
          
     </script>
</body>

</html>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>