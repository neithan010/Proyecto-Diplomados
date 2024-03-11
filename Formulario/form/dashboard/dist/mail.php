<?php
// Varios destinatarios
$para  = 'luis.levio@gmail.com' . ', '; // atención a la coma
$para .= 'llevio@unegocios.cl';

// título
$título = 'Prueba de mail';

// mensaje
$mensaje = '
<html>
<head>
  <title>Recordatorio de cumpleaños para Agosto</title>
</head>
<body>
  <p>¡Estos son los cumpleaños para Agosto!</p>
  <table>
    <tr>
      <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
    </tr>
    <tr>
      <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: Luis <llevio@ungocios.cl>, Luis Levio <luis.levio@ungocios.cl>' . "\r\n";
$cabeceras .= 'From: SGD <fotos@unegocios.cl>' . "\r\n";
$cabeceras .= 'Cc: llevio@fen.uchile.cl' . "\r\n";
$cabeceras .= 'Bcc: intranet@unegocios.cl' . "\r\n";

// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
?>