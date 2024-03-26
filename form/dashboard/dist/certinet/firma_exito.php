<?php
session_start();
include('cn.php');
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// package_id=101002&action=signed
$package_id = $_REQUEST['package_id'];
$action     = $_REQUEST['action'];

if($package_id<>''){

    $sql_data="SELECT id_postulacion, documento, haserror, cod, descripcion, packageID, documentID 
    FROM 
        intranet.certinet_upload
    WHERE 
        haserror='false'
        AND packageID=".$package_id;

    //echo '<pre>'.$sql_data.'</pre>';

    $resultado = $conexion->prepare($sql_data);
    $resultado->execute();
    $num_resultado=$resultado->rowCount();

    $id_postulacion='';
    $descripcion='';

    if ($rw_data = $resultado->fetch()){
        
        $id_postulacion = $rw_data['id_postulacion'];
        $descripcion    = $rw_data['descripcion'];
        $documento      = $rw_data['documento'];

        if($action=='signed' && $documento=='contrato'){
            $sql_up="UPDATE intranet.firma_digital
            SET
                contrato_ps_firmado=1
            WHERE
                id_postulacion=".$id_postulacion;
                
            //echo '<pre>'.$sql_up.'</pre>';

            $resultado = $conexion->prepare($sql_up);
            $resultado->execute();
            $num_resultado=$resultado->rowCount();
            //echo 'UP: '.$num_resultado.'<p>';

            
    
        }
        if($action=='signed' && $documento=='declaracion'){
            $sql_up="UPDATE intranet.firma_digital
            SET
                declaracion_firmado=1
            WHERE
                id_postulacion=".$id_postulacion;
                
            //echo '<pre>'.$sql_up.'</pre>';

            $resultado = $conexion->prepare($sql_up);
            $resultado->execute();
            $num_resultado=$resultado->rowCount();
            //echo 'UP: '.$num_resultado.'<p>';
            

        }

        $sql_dj="SELECT 
            declaracion_firmado,
            contrato_ps_firmado
        FROM 
            intranet.firma_digital
        WHERE
            id_postulacion=".$id_postulacion;
            
        //echo '<pre>'.$sql_dj.'</pre>';

        $resultado = $conexion->prepare($sql_dj);
        $resultado->execute();
        $num_resultado=$resultado->rowCount();

        $declaracion_firmado='no';
        $contrato_ps_firmado='no';
        if ($rw_data = $resultado->fetch()){
             $declaracion_firmado = $rw_data['declaracion_firmado'];
             $contrato_ps_firmado = $rw_data['contrato_ps_firmado'];
        }
    }

    if($contrato_ps_firmado==1 && $declaracion_firmado==1){
        $sql_pd="SELECT 
            pd.usuario,
            pd.clave,
            d.nom_cordinadora_admision,
            d.telefono_cordinadora_admision,
            d.mail_envio
        FROM 
            intranet.postulacion_descuento pd 
            INNER JOIN unegocios_nuevo.postulacion p ON pd.id_postulacion=p.ID_POSTULACION
            INNER JOIN intranet.diplomados d ON d.cod_diploma=p.cod_diploma
        WHERE pd.id_postulacion=".$id_postulacion;
                
        //echo '<pre>'.$sql_dj.'</pre>';

        $resultado = $conexion->prepare($sql_pd);
        $resultado->execute();
        $num_resultado=$resultado->rowCount();

        $usuario='';
        $clave='xx';
        if ($rw_data = $resultado->fetch()){
            
            $usuario    = $rw_data['usuario'];
            $clave      = $rw_data['clave'];
            $mail_envio = $rw_data['mail_envio'];

            $nom_cordinadora_admision       = $rw_data['nom_cordinadora_admision'];
            $telefono_cordinadora_admision  = $rw_data['telefono_cordinadora_admision'];

        }
    }


    $conexion = NULL;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIRMA DIGITAL - UNEGOCIOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
    .header{
        height:118px;
        background-color: #003087;
    }
    .logo_unegocios{
        margin-left:25px;
    width: 100%;
    max-width: 198px;
    height: 112px !important;
    float: left;
    position: relative;

    }
    .footer{
        height:100px;
        background-color: #003087;
    }
    .container{
        min-height: 500px;
    }
</style>
</head>
<body>
    <div class="header">
<div class="logo_unegocios">
    <img src="https://unegocios.uchile.cl/formulario/postulacion/img/unegocios2017.png" width="100%" height="auto" alt="unegocios.uchile.cl">
</div>
    </div>
    <div class="container">
    <p></p>
    
<p><?php echo ucwords(strtolower($documento)).' '.str_replace('Contrato','',$descripcion).' ID(package) '.$package_id;
            if($action=='signed'){
                echo ' y firmado.';
            }elseif($action=='none'){
                echo ' , pendiente de firma.';
                /*
                if($documento=='contrato'){
                    
                    echo '<p>Ir a firmar <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=declaracion" target="_blank" rel="noopener noreferrer">Contrato prestaci&oacute;n de servicio</a></p>';
                }
                if($documento=='declaracion'){
                    echo '<p>Ir a firmar <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=declaracion" target="_blank" rel="noopener noreferrer">Declaracion Jurada</a></p>';
                }
                */
            }else{
                echo ' ';
            }


            if($contrato_ps_firmado==0){
                echo '<p>Ir a firmar <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=contrato" target="_blank" rel="noopener noreferrer">Contrato prestaci&oacute;n de servicio</a></p>';
            }
            if($declaracion_firmado==0){
                echo '<p>Ir a firmar <a href="https://intranet.unegocios.cl/apps/admision_2021/dashboard/dist/certinet/link_integracion_x_documento.php?id_postulacion='.$id_postulacion.'&documento=declaracion" target="_blank" rel="noopener noreferrer">Declaracion Jurada</a></p>';
            }

            if($contrato_ps_firmado==1 && $declaracion_firmado==1){
?>
           <p>Ya has firmado exitosamente los documentos para tu matrícula, te invitamos a pagar de forma segura y cómoda a través de Webpay, para ello debes ingresar al siguiente link <a href="https://pagos.unegocios.cl/" target="_blank" rel="noopener noreferrer">https://pagos.unegocios.cl/</a> con el usuario <?php echo $usuario;?> y la clave <?php echo $clave;?></p>
            <p>Ante cualquier comentario o consulta, no dudes en contactar a tu Ejecutivo(a) <?php echo $nom_cordinadora_admision; ?> al teléfono <?php echo $telefono_cordinadora_admision; ?> y/o al correo electrónico <?php echo $mail_envio;?> para que te pueda ayudar a la brevedad <strong>¡ Y no te quedes sin tu cupo !</strong></p>

<p>Para conocer la normativa que rige nuestros programas, puedes revisar en este link el Reglamento: <a href="https://unegocios.uchile.cl/reglamento/" target="_blank" rel="noopener noreferrer">ver reglamento</a>.<br>

Al momento de concretar el pago aceptas todas las condiciones de nuestro reglamento y contrato.</p>
    <?php 
            }
            ?>
</p>

</div>
<div class="footer">

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
			