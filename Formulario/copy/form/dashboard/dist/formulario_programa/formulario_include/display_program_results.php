<?php
#Antes de crear la tabla tomaremos los atributos necesarios para la tabla

$num_filas = $programas_encontrados[0];
$filas = $programas_encontrados[1];

?>

<table>
    <tr>
      <th>Nombre</th>
      <th>Producto</th>
      <th>Area</th>
      <th>Modalidad</th>
      <th>Horario</th>
      <th>Nivel</th>
      <th>Escoge Una</th>
    </tr>
    <tr>
      <td>opciones filas</td>
      <td><input type="radio" name="selectedRow"></td>
    </tr>
</table>

<button onclick="enviarDatos()">Seleccionar</button>

<script>
    function enviarDatos() {
      var selectedRow = document.querySelector('input[name=selectedRow]:checked');
      if (selectedRow) {
        var cells = selectedRow.parentNode.parentNode.getElementsByTagName('td');
        var rowData = {
          nombre: cells[0].innerText,
          edad: cells[1].innerText
        };
        // Aquí puedes hacer lo que desees con los datos seleccionados, por ejemplo, enviarlos a un archivo PHP
        console.log(rowData);
        // Aquí puedes enviar los datos a otro archivo PHP utilizando Fetch API o XMLHttpRequest
      } else {
        alert("Por favor selecciona una fila.");
      }
    }
</script>