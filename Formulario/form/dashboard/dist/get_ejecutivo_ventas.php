<?php 
#Query para obtener los datos de un ejecutivo de ventas segun su id.
$sql_ejecutivo_ventas = "SELECT u.Nombre,
                                u.Apellido,
                                u.email,
                                u.telefono
                                FROM intranet.usuarios_int u
                                WHERE u.usr = :ejecutivo_ventas";

$stmt_ejecutivo_ventas= $con->prepare($sql_ejecutivo_ventas);
$stmt_ejecutivo_ventas->setFetchMode(PDO::FETCH_ASSOC);
$stmt_ejecutivo_ventas->bindParam('ejecutivo_ventas', $usr_cordinador_ej);
$stmt_ejecutivo_ventas->execute();

if($rw_ejecutivo = $stmt_ejecutivo_ventas->fetch()){
    $arr_ejecutivo[] = array(
        "Nombre" => $rw_ejecutivo['Nombre']. " ". $rw_ejecutivo['Apellido'],
        "Email" => $rw_ejecutivo['email'],
        "Telefono" => $rw_ejecutivo['telefono']
    );
}