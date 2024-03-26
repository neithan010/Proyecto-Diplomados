<?php
/*
foreach($_REQUEST as $campo => $valor ){
	echo $campo.': '.var_dump($valor) .'<br>';
}

echo '<hr>';
exit()
*/

?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('../../cn/cn_PDO.php');	
//include('../../cn/cn_PDO2.php');	

$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
    $id_postulacion=$_REQUEST['id_postulacion'];
}
if($id_postulacion==''){ 
    echo 'Error recepccionar ID';
    exit();
}
if(isset($_REQUEST['check_int'])){
    $arr_check_int=$_REQUEST['check_int'];
}else{
    //$arr_check_int=[];
    $arr_check_int=array();
}

if(isset($_REQUEST['check_emp'])){
    $arr_check_emp=$_REQUEST['check_emp'];
}else{
    //$arr_check_emp=[];
    $arr_check_emp=array();
}

$nombre_empresa     = isset($_REQUEST['nombre_empresa'])?$_REQUEST['nombre_empresa']:'';
$nombre_empresa     = htmlspecialchars(addslashes($nombre_empresa));
$rut_empresa        = isset($_REQUEST['rut_empresa'])?$_REQUEST['rut_empresa']:'';
$direccion_empresa  = isset($_REQUEST['direccion_empresa'])?utf8_decode($_REQUEST['direccion_empresa']):'';
$direccion_empresa  = htmlspecialchars(addslashes($direccion_empresa));

$numdoc=date('YmdHis_').$id_postulacion;

$obs_dsc = isset($_REQUEST['comentario'])?utf8_decode($_REQUEST['comentario']):'';

//exit();


$sql_postulante="SELECT 
    p.ID_POSTULACION as id_postulacion,
    p.cod_diploma,
    d.Cod_interno AS ceco,
    d.DIPLOMADO as programa,
    p.FECHA_POST as fecha_postulacion,
    pe.fecha_in AS fecha_aceptada,
    p.NOMBRES,
    p.APELLIDO_PAT,
    p.APELLIDO_MAT,
    CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo,
    p.RUT,
    p.ID_FINANCIAMIENTO,
    d.nom_cordinadora_admision,
	CONCAT_WS(' ',p.DIREC_PARTICULAR, p.numero, if(p.depto_of_par<>'',concat('of/depto ',p.depto_of_par),''),',',com.nombre,',',reg.nombre) direccion,
	p.CELULAR as celular,
	p.TELEFONO as telefono,
	p.EMAIL as email,
    p.NACIONALIDAD as nacionalidad,
    p.RUT_EMPRESA,
    p.RAZON_SOCIAL,
    p.periodo

    FROM 
        unegocios_nuevo.postulacion p 
        INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
        LEFT JOIN intranet.postulacion_estado pe ON pe.idpostulacion=p.ID_POSTULACION AND concat(pe.etapa,pe.estado)= 2020
        LEFT  JOIN unegocios_nuevo.comunas com ON com.cod_comuna=p.COMUNA
	    LEFT  JOIN unegocios_nuevo.regiones reg ON reg.cod_region=p.region
    WHERE 
        p.ID_POSTULACION=". $id_postulacion;

//echo '<pre>'.$sql_postulante.'</pre>';
//exit();

$stmt_postulante = $con->prepare($sql_postulante);
$stmt_postulante ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulante ->execute();
$num_postulantea =$stmt_postulante ->rowCount();	
//echo '::'.$num_postulantea;

if ($rw_data  = $stmt_postulante ->fetch()){

	
    $cod_diploma        = $rw_data['cod_diploma'];
    $ceco               = $rw_data['ceco'];
	$programa           = utf8_encode($rw_data['programa']);
	$fecha_postulacion  = $rw_data['fecha_postulacion'];
    $fecha_aceptada     = $rw_data['fecha_aceptada'];
    $nombres            = $rw_data['NOMBRES'];
    $apellido_pat       = $rw_data['APELLIDO_PAT'];
    $apellido_mat       = $rw_data['APELLIDO_MAT'];
    $nombre_completo    = utf8_encode($rw_data['nombre_completo']);
    $rut                = $rw_data['RUT'];
    $direccion          = utf8_encode($rw_data['direccion']);
    $celular            = utf8_encode($rw_data['celular']);
    $telefono           = utf8_encode($rw_data['telefono']);
    $email              = utf8_encode($rw_data['email']);
    $nacionalidad       = utf8_encode($rw_data['nacionalidad']);
    $qpaga              = $rw_data['ID_FINANCIAMIENTO'];
    $rut_empresa_bbdd   = $rw_data['RUT_EMPRESA'];
    $razon_social       = utf8_encode($rw_data['RAZON_SOCIAL']);
    $periodo            = $rw_data['periodo'];
}
if($rut_empresa_bbdd<>'' && $rut_empresa=='' ){
    $rut_empresa=$rut_empresa_bbdd;
}


//-----------------------------------------------
//  caso de correcciones.


	$sql="select
	idcomprobante_pago, 
	id_postulacion, 
	tipo_comprobante, 
	n
from 
	intranet.comprobante_pago cp 
where 
	cp.id_postulacion=".$id_postulacion."
	and cp.corregido is null
	and cp.tipo_comprobante =1";
		
	$stmt = $con->prepare($sql);
    $stmt ->setFetchMode(PDO::FETCH_ASSOC);
    $stmt ->execute();
    $num_existe =$stmt ->rowCount();	
    
    if($num_existe>0){
		$sql="UPDATE intranet.comprobante_pago SET corregido=1 where id_postulacion=".$id_postulacion;
		//echo '[1]'.$sql.'<p>';
		$stmt = $con->prepare($sql);
        $stmt ->setFetchMode(PDO::FETCH_ASSOC);
        $stmt ->execute();
	}
	
//------------------------------------------------


require('../include/fpdf.php');

class PDF extends FPDF
{
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Etiqueta
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extraer atributos
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Etiqueta de cierre
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function Header()
    {
        //Logo
        $this->Image('cplogocdg2017.jpg',10,8,25);
        //Arial bold 15
        $this->SetFont('Arial','B',14);
    $this->Ln(1);
        //Movernos a la derecha
        $this->Cell(40);
        //Título
        $this->Cell(100,10,'COMPROBANTE DE INGRESO INTERNO','B',0,'C');
        //Salto de línea
        $this->Ln(15);
    }

    //Pie de página
    function Footer()
    {
        //Logo
        //$this->Image('pie2.jpg',140,260,60);

        $this->SetY(-28);

        $this->SetFont('Times','',8);
        $this->SetTextColor(123,123,132);

        $this->Cell(175,10,'https://unegocios.uchile.cl',0,0,'R');
        $this->Ln(4);
        $this->Cell(175,10,'Diagonal Paraguay 257, Piso 9, of. 903, Santiago Chile.',0,0,'R');
        $this->Ln(4);
        $this->Cell(175,10,'Tel.: (56 2) 29783380 - E-mail: contacto@unegocios.cl',0,0,'R');

        
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',6);
        //Número de página
        $this->SetTextColor(123,123,132);
        $this->Cell(0,10,date('Ymd-H.i.s'),0,0,'C');
    }
}


$pdf = new PDF();
// Primera página
$pdf->AddPage();

//---------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'N.','0',0,'L');
$pdf->Cell(80,5,$numdoc,'0',0,'L');
$pdf->Ln(4);

//---------------------------------------------------------
$pdf->Cell(40,5,'FACTURAR A ','0',0,'L');
$pdf->SetFont('Arial');

if($nombre_empresa<>'' && ($qpaga=='Empresa' || $qpaga=='Interesado/Empresa')){
    $pdf->Cell(80,5,': '.utf8_decode($nombre_empresa),'0',0,'L');
}else{
    $pdf->Cell(80,5,': '.utf8_decode($nombre_completo),'0',0,'L');
}


$pdf->Ln(4);
//-------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'RUT ','0',0,'L');
$pdf->SetFont('Arial');
if($rut_empresa<>''){
    $pdf->Cell(80,5,': '.$rut_empresa,'0',0,'L');
}else{
    $pdf->Cell(80,5,': '.$rut,'0',0,'L');
}

$pdf->Ln(4);
//---------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'DIRECCION ','0',0,'L');
$pdf->SetFont('Arial');
//if($direccion_empresa<>''){
if($qpaga=='Empresa' || $qpaga=='Interesado/Empresa'){   
    if(trim($direccion_empresa) == '' && trim($direccion) <> ''){ $direccion_empresa=$direccion; } 
    $pdf->Cell(80,5,': '.$direccion_empresa,'0',0,'L');
}else{
    $pdf->Cell(80,5,': '.utf8_decode($direccion),'0',0,'L');
}

$pdf->Ln(4);
//-------------------

//-------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'PROGRAMA ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5,': '.utf8_decode($programa)  ,'0',0,'L');
$pdf->Ln(4);
//-------------------

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'PARTICIPANTE ','0',0,'L');
$pdf->SetFont('Arial');
/*$pdf->Cell(80,5,': '.utf8_decode($_REQUEST['participante']),'0',0,'L');*/
$pdf->Cell(80,5,': '.utf8_decode($nombre_completo),'0',0,'L');
$pdf->Ln(4);
//--------------------

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'NACIONALIDAD ','0',0,'L');
$pdf->SetFont('Arial');
/*$pdf->Cell(80,5,': '.utf8_decode($_REQUEST['participante']),'0',0,'L');*/
$pdf->Cell(80,5,': '.utf8_decode($nacionalidad),'0',0,'L');
$pdf->Ln(4);
//--------------------

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'EMAIL ','0',0,'L');
$pdf->SetFont('Arial');
/*$pdf->Cell(80,5,': '.utf8_decode($_REQUEST['participante']),'0',0,'L');*/
$pdf->Cell(80,5,': '.$email,'0',0,'L');
$pdf->Ln(4);

//--------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'PERIODO ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5,': '.utf8_decode($periodo),'0',0,'L');
$pdf->Ln(4);
//-----------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'COD INTERNO ','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5,': '.utf8_decode($ceco),'0',0,'L');
$pdf->Ln(4);
//-----------------------------------------

$text_oc='';
if(isset($_REQUEST['text_oc'])){
    $text_oc=$_REQUEST['text_oc'];
}
/*
if(isset($_REQUEST['text_oc_emp'])){
    $text_oc.=' '.$_REQUEST['text_oc_emp'];
}
*/


if($qpaga=='Interesado'){

    $sql="INSERT INTO intranet.comprobante_pago
            (id_postulacion,
            n,
            facturar_a,
            rut,
            direccion,
            programa,
            participante,
            orden_compra,
            periodo,
            fecha,
            tel_contacto,
            obs_dsc
            )
            VALUES
            (
            ".$id_postulacion.",
            '".$numdoc."',
            '".$nombre_completo."',
            '".$rut."',
            '".$direccion."',
            '".utf8_decode($programa)."',
            '".utf8_decode($nombre_completo)."',
            '".$text_oc."',
            '".$periodo."',
            NOW(),
            '".$telefono."',
            '".$obs_dsc."'
            )";
	}else{
        $sql="INSERT INTO intranet.comprobante_pago
        (id_postulacion,
        n,
        facturar_a,
        rut,
        direccion,
        programa,
        participante,
        orden_compra,
        periodo,
        fecha,
        tel_contacto,
        obs_dsc
        )
        VALUES
        (
        ".$id_postulacion.",
        '".$numdoc."',
        '".$nombre_empresa."',
        '".$rut_empresa."',
        '".$direccion_empresa."',
        '".utf8_decode($programa)."',
        '".utf8_decode($nombre_completo)."',
        '".$text_oc."',
        '".$periodo."',
        NOW(),
        '".$telefono."',
        '".$obs_dsc."'
        )";
    }	
        //echo 'comprobante_pago:<pre>'.$sql.'</pre>';
        //exit();

        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_cp = $con->lastInsertId();

        $fp = fopen("log_forma_pago.txt", "a");
        fwrite($fp, $sql);
        fclose($fp);

        if(count($arr_check_int)>0){
            $pdf->Ln(2);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,'Interesado ','0',0,'L');
            $pdf->Ln(4);

        }

        $pdf->SetFont('Arial','',8);

    //-----------------
    // TRANSFERENCIA
    //-----------------
    if (in_array("tx", $arr_check_int)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        //$pdf->SetFont('','B');
        $pdf->SetFont('Arial','B',8);

        $fill=false;
            $pdf->Cell(170,5,'Transferencia','LR',0,'L',1);
            $pdf->Ln();

        $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['banco_tx'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_tx'].'.-','LR',0,'L',$fill);
            $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
            (
            ".$id_cp.",
            'Transferencia',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'
        )";
        //echo '[3]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();
    
        $sql="INSERT INTO intranet.pago
        (idforma_pago,
        monto,
        fecha_pago,
        num_documento,
        banco
        )VALUES(
        ".$id_fp.",
        ".str_replace(".","",$_REQUEST['monto_tx']).",
        CURDATE(),
        '',
        '".$_REQUEST['banco_tx']."'
        )";
        //echo '[4]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

    }
    //----------------------------------
    // Tarjeta Credito
    //----------------------------------
    if (in_array("tc", $arr_check_int)) {


        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial','B');

        $fill=false;
		$pdf->Cell(170,5,'Tarjeta Credito .','LR',0,'L',1);
		$pdf->Ln();

        $pdf->SetFont('');
		$fill=false;
		$pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['banco_tc'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		$pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['nom_tc'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		
		$pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_cuotas'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;

        $monto_tc=str_replace(".","",$_REQUEST['monto_tc']);
        $cuota_num_tc=str_replace(".","",$_REQUEST['num_cuotas']);
        
        if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}

        $cuota_valor_tc=$monto_tc/$cuota_num_tc;
        $cuota_valor_tc=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

		$pdf->Cell(25,5,'Valor Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,number_format($cuota_valor_tc, 0, ",", ".").'.-','LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		
        $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
        //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
        $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher'])).' '.$_REQUEST['hora_voucher'],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill=false;		
		
		
		$pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
		$pdf->Cell(145,6,$_REQUEST['monto_tc'].'.-','LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_operacion'],'LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Cod. verificacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['cod_autorizacion'],'LR',0,'L',$fill);
		$pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

        $sql="INSERT INTO intranet.forma_pago
        (idcomprobante_pago,
        forma_pago,
        uf,
        descuento,
        total_a_pagar,
        atendido_por,
        fecha_atencion,
        fecha_ingreso,
        qpaga)
        VALUES
        (
        ".$id_cp.",
        'Tarjeta Credito',
        '".$_REQUEST['uf']."',
        '".$_REQUEST['total_descuento']."',
        '".$_REQUEST['total_pagar']."',
        '".$_REQUEST['atendido']."',
        '".$_REQUEST['fecha_imp']."',
        NOW(),
        'INT'	
        )";
        //echo '[7]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();

        $fecha_bd=$_REQUEST['fecha_voucher'];

        if(($monto_tc%$cuota_num_tc)==0){
            
            $cuota_valor_tc=$monto_tc/$cuota_num_tc;
            
            for($i=0;$i<$cuota_num_tc;$i++){
                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;

                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_valor_tc.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc']." xxxx-xxxx-xxx-".$_REQUEST['num_tc']."',
                    '".$_REQUEST['banco_tc']."',
                    '".$_REQUEST['cod_autorizacion']."',
                    '".$_REQUEST['num_operacion']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher']."',
                    '".$_REQUEST['nom_tc']."'
                    )";

                $stmt = $con->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                //--------------------------------------------
                    $log_carga = 'log_carga.txt';
                    $sql = $sql."\r\n";
                    file_put_contents($log_carga, $sql, FILE_APPEND | LOCK_EX);		
                //--------------------------------------------
            }

        }else{

            $cuota_valor_tc=$monto_tc/$cuota_num_tc;

            $cuota_num_tc_menor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_DOWN);
            $cuota_num_tc_mayor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

            for($i=0;$i<($cuota_num_tc-1);$i++){

                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                
                
                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_menor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc']." xxxx-xxxx-xxx-".$_REQUEST['num_tc']."',
                    '".$_REQUEST['banco_tc']."',
                    '".$_REQUEST['cod_autorizacion']."',
                    '".$_REQUEST['num_operacion']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher']."',
                    '".$_REQUEST['nom_tc']."'
                    )";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();

            }
            
            $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
            $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_mayor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc']." xxxx-xxxx-xxx-".$_REQUEST['num_tc']."',
                    '".$_REQUEST['banco_tc']."',
                    '".$_REQUEST['cod_autorizacion']."',
                    '".$_REQUEST['num_operacion']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher']."',
                    '".$_REQUEST['nom_tc']."'
                    )";

            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        }
    }
    //----------------------------------
    // WEBPAY 
    //----------------------------------
    if (in_array("webpay", $arr_check_int)) {
        
        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'WEBPAY .','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;
        $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['banco_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['nom_tc_wp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
        $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_cuotas_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;

        $monto_tc=str_replace(".","",$_REQUEST['monto_tc_wp']);
        $cuota_num_tc=str_replace(".","",$_REQUEST['num_cuotas_wp']);
        
        if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}

        $cuota_valor_tc=$monto_tc/$cuota_num_tc;
        $cuota_valor_tc=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

        $pdf->Cell(25,5,'Valor Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,number_format($cuota_valor_tc, 0, ",", ".").'.-','LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
            $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
            //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
            $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_wp'])).' '.$_REQUEST['hora_voucher_wp'],'LR',0,'L',$fill);
            
            $pdf->Ln();
            $fill=false;		
        
        
        $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,6,$_REQUEST['monto_tc_wp'].'.-','LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_operacion_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Codigo verificacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['cod_autorizacion_wp'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
        (
            ".$id_cp.",
            'WEBPAY',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'	
        )";
        //echo '[7]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();

        $fecha_bd=$_REQUEST['fecha_voucher_wp'];

        if(($monto_tc%$cuota_num_tc)==0){
            
            $cuota_valor_tc=$monto_tc/$cuota_num_tc;
            
            for($i=0;$i<$cuota_num_tc;$i++){
                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;

                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_valor_tc.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp']."',
                    '".$_REQUEST['banco_wp']."',
                    '".$_REQUEST['cod_autorizacion_wp']."',
                    '".$_REQUEST['num_operacion_wp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher']."',
                    '".$_REQUEST['nom_tc']."'
                    )";
                
                $stmt = $con->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
            }

        }else{

            $cuota_valor_tc=$monto_tc/$cuota_num_tc;

            $cuota_num_tc_menor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_DOWN);
            $cuota_num_tc_mayor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

            for($i=0;$i<($cuota_num_tc-1);$i++){

                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                
                
                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_menor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp']."',
                    '".$_REQUEST['banco_wp']."',
                    '".$_REQUEST['cod_autorizacion_wp']."',
                    '".$_REQUEST['num_operacion_wp']."',
                    '".$cuota_num_tc."'
                    )";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();

            }
            
            $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
            $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_mayor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp']."',
                    '".$_REQUEST['banco_wp']."',
                    '".$_REQUEST['cod_autorizacion_wp']."',
                    '".$_REQUEST['num_operacion_wp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher']."',
                    '".$_REQUEST['nom_tc']."'
                    )";

            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        }  
    }

    //----------------------------------
    // WEBPAY PAGO DIFERIDO
    //----------------------------------
    if (in_array("webpay_diferido", $arr_check_int)) {

        $arr_banco_wp_df         = $_REQUEST['banco_wp_df'];
        $arr_num_tc_wp_df        = $_REQUEST['num_tc_wp_df'];
        $arr_num_cuotas_df       = $_REQUEST['num_cuotas_df'];
        $arr_monto_tc_df         = $_REQUEST['monto_tc_df'];
        $arr_fecha_voucher_df    = $_REQUEST['fecha_voucher_df'];
        $arr_num_operacion_df    = $_REQUEST['num_operacion_df'];
        $arr_cod_autorizacion_df = $_REQUEST['cod_autorizacion_df'];
        $monto_tc_df = array_sum($arr_monto_tc_df); 

    $i=0;
       foreach($arr_num_tc_wp_df as $num_tc_wp_df){
       
            $pdf->SetFillColor(102,161,204);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(62,105,184);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('','B');

            $fill=false;
            $pdf->Cell(170,5,'WEBPAY TARJETA '.($i+1),'LR',0,'L',1);
            $pdf->Ln();

            $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_banco_wp_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
            $pdf->Cell(145,5,'Numero: xxxx-xxxx-xxx-'.$arr_num_tc_wp_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            
            $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_num_cuotas_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;

            $monto_tc=str_replace(".","",$arr_monto_tc_df[$i]);
            $cuota_num_tc=str_replace(".","",$arr_num_cuotas_df[$i]);
            
            if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}

            $cuota_valor_tc=$monto_tc/$cuota_num_tc;
            $cuota_valor_tc=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

            $pdf->Cell(25,5,'Valor Cuota ','LR',0,'L',$fill);
            $pdf->Cell(145,5,number_format($cuota_valor_tc, 0, ",", ".").'.-','LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            
                $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
                //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
                $pdf->Cell(145,5, date('d-m-Y H:i:s', strtotime($arr_fecha_voucher_df[$i])),'LR',0,'L',$fill);
                
                $pdf->Ln();
                $fill=false;		
            
            
            $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,6,number_format($arr_monto_tc_df[$i], 0, ",", ".").'.-','LR',0,'L',$fill);
            $pdf->Ln();
            
            $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_num_operacion_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            
            $pdf->Cell(25,5,'Codigo verificacion ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_cod_autorizacion_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();

            $pdf->Cell(170,0,'','T');
            $pdf->Ln(3);
            //------------------------------------------------------

            $sql="INSERT INTO intranet.forma_pago
                (idcomprobante_pago,
                forma_pago,
                uf,
                descuento,
                total_a_pagar,
                atendido_por,
                fecha_atencion,
                fecha_ingreso,
                qpaga)
            VALUES
            (
                ".$id_cp.",
                'WEBPAY DIFERIDO',
                '".$_REQUEST['uf']."',
                '".$_REQUEST['total_descuento']."',
                '".$_REQUEST['total_pagar']."',
                '".$_REQUEST['atendido']."',
                '".$_REQUEST['fecha_imp']."',
                NOW(),
                'INT'	
            )";
            //echo '[7]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $total_afectado=$stmt->rowCount();
            $id_fp = $con->lastInsertId();

            $fecha_bd=$arr_fecha_voucher_df[$i];

            if(($monto_tc % $cuota_num_tc)==0){
                
                $cuota_valor_tc=$monto_tc/$cuota_num_tc;
                
                for($x = 0; $x < $cuota_num_tc; $x++){
                    $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;

                    $sql="INSERT INTO intranet.pago
                        (idforma_pago,
                        monto,
                        fecha_pago,
                        num_documento,
                        banco,
                        codigo_verificacion,
                        codigo_operacion,
                        num_cuotas,
                        hora_voucher,
                        nom_tc
                        )VALUES(
                        ".$id_fp.",
                        ".$cuota_valor_tc.",
                        '".$fecha_bd."',
                        'xxxx-xxxx-xxx-".$arr_num_tc_wp_df [$i]."',
                        '".$arr_banco_wp_df[$i]."',
                        '".$arr_cod_autorizacion_df[$i]."',
                        '".$arr_num_operacion_df[$i]."',
                        '".$cuota_num_tc."',
                        '".date("H:i:s", strtotime($arr_fecha_voucher_df[$i]))."',
                        'Otro'
                        )";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();
                }

            }else{

                $cuota_valor_tc=$monto_tc/$cuota_num_tc;

                $cuota_num_tc_menor = round($cuota_valor_tc, 0, PHP_ROUND_HALF_DOWN);
                $cuota_num_tc_mayor = round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

                for($x=0 ; $x<($cuota_num_tc-1) ; $x++){

                    $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                    
                    
                    $sql="INSERT INTO intranet.pago
                        (idforma_pago,
                        monto,
                        fecha_pago,
                        num_documento,
                        banco,
                        codigo_verificacion,
                        codigo_operacion,
                        num_cuotas,
                        hora_voucher,
                        nom_tc
                        )VALUES(
                        ".$id_fp.",
                        ".$cuota_num_tc_menor.",
                        '".$fecha_bd."',
                        'xxxx-xxxx-xxx-".$arr_num_tc_wp_df[$i]."',
                        '".$arr_banco_wp_df[$i]."',
                        '".$arr_cod_autorizacion_df[$i]."',
                        '".$arr_num_operacion_df[$i]."',
                        '".$cuota_num_tc."',
                        '".date("H:i:s", strtotime($arr_fecha_voucher_df[$i]))."',
                        'Otro'
                        )";
                        
                        $stmt = $con->prepare($sql);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt->execute();

                }
                
                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                $sql="INSERT INTO intranet.pago
                        (idforma_pago,
                        monto,
                        fecha_pago,
                        num_documento,
                        banco,
                        codigo_verificacion,
                        codigo_operacion,
                        num_cuotas,
                        hora_voucher,
                        nom_tc
                        )VALUES(
                        ".$id_fp.",
                        ".$cuota_num_tc_mayor.",
                        '".$fecha_bd."',
                        'xxxx-xxxx-xxx-".$arr_num_tc_wp_df[$i]."',
                        '".$arr_banco_wp_df[$i]."',
                        '".$arr_cod_autorizacion_df[$i]."',
                        '".$arr_num_operacion_df[$i]."',
                        '".$cuota_num_tc."',
                        '".date("H:i:s", strtotime($arr_fecha_voucher_df[$i]))."',
                        'Otro'
                        )";

                $stmt = $con->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
            } 
            $i++;     
       } 
       
    }

    //----------
    // PAT
    //----------    
    if (in_array("pat", $arr_check_int)) {
        
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');
    
        $fill=false;
            $pdf->Cell(170,5,'PAT','LR',0,'L',1);
            $pdf->Ln();
    
            $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'ID PAT ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['id_pat'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_pat'].'.-','LR',0,'L',$fill);
            $pdf->Ln();
        
            $pdf->Cell(170,0,'','T');
            $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
            VALUES
            (
            ".$id_cp.",
            'PAT',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'
            )";
            //echo '[3]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $total_afectado=$stmt->rowCount();
            $id_fp = $con->lastInsertId();
        
        $sql="INSERT INTO intranet.pago
            (idforma_pago,
            monto,
            fecha_pago,
            num_documento,
            banco
            )VALUES(
            ".$id_fp.",
            ".str_replace(".","",$_REQUEST['monto_pat']).",
            CURDATE(),
            '".$_REQUEST['id_pat']."',
            ''
            )";
            //echo '[4]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        
    }
	//---------
    // OC
    //----------
	if (in_array("oc", $arr_check_int)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'Orden de Compra','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;

        $pdf->Cell(25,5,'OC ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['text_oc'].'.-','LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,'Rut Empresa ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['rut_empresa'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,'Razon Social ','LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['razon_social']),'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,utf8_decode('Dirección '),'LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['direccion_empresa']),'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,'Giro ','LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['giro']),'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['monto_oc'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
            VALUES
            (
            ".$id_cp.",
            'Orden de Compra',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'	
            )";
            //echo '[9]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $total_afectado=$stmt->rowCount();
            $id_fp = $con->lastInsertId();
        

        $sql="INSERT INTO intranet.pago
            (idforma_pago,
            monto,
            fecha_pago,
            num_documento,
            banco
            )VALUES(
            ".$id_fp.",
            ".str_replace(".","",$_REQUEST['monto_oc']).",
            CURDATE(),
            '".$_REQUEST['text_oc']."',
            ''
            )";
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();    

        $sql="INSERT INTO intranet.ordenes_compra_cp
            (id_postulacion, oc, rut, razon_social, direccion, giro, monto
            )VALUES(
            ".$id_postulacion.",
            '".$_REQUEST['text_oc']."',
            '".$_REQUEST['rut_empresa']."',
            '".$_REQUEST['razon_social']."',
            '".$_REQUEST['dir_emp']."',
            '".$_REQUEST['giro']."',
            '".$_REQUEST['monto_oc']."',
            )";
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(); 
    }
	
	//---------
    // Vale Vista
    //----------
	if (in_array("vv", $arr_check_int)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        //$pdf->SetFont('','B');
        $pdf->SetFont('Arial','B',8);

        $fill=false;
            $pdf->Cell(170,5,'Vale Vista','LR',0,'L',1);
            $pdf->Ln();

        $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['banco_vv'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_vv'].'.-','LR',0,'L',$fill);
            $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
            (
            ".$id_cp.",
            'Vale Vista',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'
        )";
        //echo '[3]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();
    
        $sql="INSERT INTO intranet.pago
        (idforma_pago,
        monto,
        fecha_pago,
        num_documento,
        banco
        )VALUES(
        ".$id_fp.",
        ".str_replace(".","",$_REQUEST['monto_vv']).",
        CURDATE(),
        '',
        '".$_REQUEST['banco_vv']."'
        )";
        //echo '[4]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }
	
//------------------------------------------------------
// PAGO EMPRESA
//------------------------------------------------------
if(count($arr_check_emp)>0){
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,5,'Empresa ','0',0,'L');
    $pdf->Ln(4);

}

    //-----------------
    // TRANSFERENCIA
    //-----------------
    if (in_array("tx_emp", $arr_check_emp)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        //$pdf->SetFont('','B');
        $pdf->SetFont('Arial','B',8);

        $fill=false;
            $pdf->Cell(170,5,'Transferencia','LR',0,'L',1);
            $pdf->Ln();

        $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['banco_tx_emp'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_tx_emp'].'.-','LR',0,'L',$fill);
            $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
            (
            ".$id_cp.",
            'Transferencia',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'
        )";
        //echo '[3]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();
    
        $sql="INSERT INTO intranet.pago
        (idforma_pago,
        monto,
        fecha_pago,
        num_documento,
        banco
        )VALUES(
        ".$id_fp.",
        ".str_replace(".","",$_REQUEST['monto_tx_emp']).",
        CURDATE(),
        '',
        '".$_REQUEST['banco_tx_emp']."'
        )";
        //echo '[4]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

    }
    //----------------------------------
    // Tarjeta Credito
    //----------------------------------
    if (in_array("tc_emp", $arr_check_emp)) {


        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial','B');

        $fill=false;
		$pdf->Cell(170,5,'Tarjeta Credito .','LR',0,'L',1);
		$pdf->Ln();

        $pdf->SetFont('');
		$fill=false;
		$pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['banco_tc_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		$pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['nom_tc_emp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		
        $monto_tc=str_replace(".","",$_REQUEST['monto_tc_emp']);
        $cuota_num_tc=str_replace(".","",$_REQUEST['num_cuotas_emp']);
        
        if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}

		$pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$cuota_num_tc,'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;

        $cuota_valor_tc=$monto_tc/$cuota_num_tc;
        $cuota_valor_tc=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

		$pdf->Cell(25,5,'Valor Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,number_format($cuota_valor_tc, 0, ",", ".").'.-','LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		
        $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
        //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
        $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_emp'])).' '.$_REQUEST['hora_voucher_emp'],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill=false;		
		
		
		$pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
		$pdf->Cell(145,6,$_REQUEST['monto_tc_emp'].'.-','LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_operacion_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Cod. verificacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['cod_autorizacion_emp'],'LR',0,'L',$fill);
		$pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

        $sql="INSERT INTO intranet.forma_pago
        (idcomprobante_pago,
        forma_pago,
        uf,
        descuento,
        total_a_pagar,
        atendido_por,
        fecha_atencion,
        fecha_ingreso,
        qpaga)
        VALUES
        (
        ".$id_cp.",
        'Tarjeta Credito',
        '".$_REQUEST['uf']."',
        '".$_REQUEST['total_descuento']."',
        '".$_REQUEST['total_pagar']."',
        '".$_REQUEST['atendido']."',
        '".$_REQUEST['fecha_imp']."',
        NOW(),
        'EMP'	
        )";
        //echo '[7]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();

        $fecha_bd=$_REQUEST['fecha_voucher_emp'];

        if(($monto_tc%$cuota_num_tc)==0){
            
            $cuota_valor_tc=$monto_tc/$cuota_num_tc;
            
            for($i=0;$i<$cuota_num_tc;$i++){
                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;

                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_valor_tc.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_emp']."',
                    '".$_REQUEST['banco_tc_emp']."',
                    '".$_REQUEST['cod_autorizacion_emp']."',
                    '".$_REQUEST['num_operacion_emp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher_emp']."',
                    '".$_REQUEST['nom_tc_emp']."'
                    )";

                $stmt = $con->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();

                //--------------------------------------------
                    $log_carga = 'log_carga.txt';
                    $sql = $sql."\r\n";
                    file_put_contents($log_carga, $sql, FILE_APPEND | LOCK_EX);		
                //--------------------------------------------
            }

        }else{

            $cuota_valor_tc=$monto_tc/$cuota_num_tc;

            $cuota_num_tc_menor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_DOWN);
            $cuota_num_tc_mayor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

            for($i=0;$i<($cuota_num_tc-1);$i++){

                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                
                
                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_menor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_emp']."',
                    '".$_REQUEST['banco_tc_emp']."',
                    '".$_REQUEST['cod_autorizacion_emp']."',
                    '".$_REQUEST['num_operacion_emp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher_emp']."',
                    '".$_REQUEST['nom_tc_emp']."'
                    )";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();

            }
            
            $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
            $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_mayor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_emp']."',
                    '".$_REQUEST['banco_tc_emp']."',
                    '".$_REQUEST['cod_autorizacion_emp']."',
                    '".$_REQUEST['num_operacion_emp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher_emp']."',
                    '".$_REQUEST['nom_tc_emp']."'
                    )";

            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        }
    }
    //----------------------------------
    // WEBPAY 
    //----------------------------------
    if (in_array("webpay_emp", $arr_check_emp)) {
        
        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'WEBPAY .','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;
        $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['banco_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['nom_tc_wp_emp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
        $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_cuotas_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;

        $monto_tc=str_replace(".","",$_REQUEST['monto_tc_wp_emp']);
        $cuota_num_tc=str_replace(".","",$_REQUEST['num_cuotas_wp_emp']);
        
        if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}

        $cuota_valor_tc=$monto_tc/$cuota_num_tc;
        $cuota_valor_tc=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

        $pdf->Cell(25,5,'Valor Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,number_format($cuota_valor_tc, 0, ",", ".").'.-','LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
            $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
            //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
            $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_wp_emp'])).' '.$_REQUEST['hora_voucher_wp_emp'],'LR',0,'L',$fill);
            
            $pdf->Ln();
            $fill=false;		
        
        
        $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,6,$_REQUEST['monto_tc_wp_emp'].'.-','LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_operacion_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Codigo verificacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['cod_autorizacion_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
        (
            ".$id_cp.",
            'WEBPAY',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'EMP'	
        )";
        //echo '[7]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();

        $fecha_bd=$_REQUEST['fecha_voucher_wp_emp'];

        if(($monto_tc%$cuota_num_tc)==0){
            
            $cuota_valor_tc=$monto_tc/$cuota_num_tc;
            
            for($i=0;$i<$cuota_num_tc;$i++){
                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;

                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_valor_tc.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp_emp']."',
                    '".$_REQUEST['banco_wp_emp']."',
                    '".$_REQUEST['cod_autorizacion_wp_emp']."',
                    '".$_REQUEST['num_operacion_wp_emp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher_emp']."',
                    '".$_REQUEST['nom_tc_emp']."'
                    )";
                
                $stmt = $con->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $stmt->execute();
            }

        }else{

            $cuota_valor_tc=$monto_tc/$cuota_num_tc;

            $cuota_num_tc_menor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_DOWN);
            $cuota_num_tc_mayor=round($cuota_valor_tc, 0, PHP_ROUND_HALF_UP);

            for($i=0;$i<($cuota_num_tc-1);$i++){

                $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
                
                
                $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_menor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp_emp']."',
                    '".$_REQUEST['banco_wp_emp']."',
                    '".$_REQUEST['cod_autorizacion_wp_emp']."',
                    '".$_REQUEST['num_operacion_wp_emp']."',
                    '".$cuota_num_tc."'
                    )";
                    
                    $stmt = $con->prepare($sql);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();

            }
            
            $fecha_bd = date('Y-m-d',strtotime ( '+1 month' , strtotime ( $fecha_bd ))) ;
            $sql="INSERT INTO intranet.pago
                    (idforma_pago,
                    monto,
                    fecha_pago,
                    num_documento,
                    banco,
                    codigo_verificacion,
                    codigo_operacion,
                    num_cuotas,
                    hora_voucher,
                    nom_tc
                    )VALUES(
                    ".$id_fp.",
                    ".$cuota_num_tc_mayor.",
                    '".$fecha_bd."',
                    '".$_REQUEST['nom_tc_wp_emp']." xxxx-xxxx-xxx-".$_REQUEST['num_tc_wp_emp']."',
                    '".$_REQUEST['banco_wp_emp']."',
                    '".$_REQUEST['cod_autorizacion_wp_emp']."',
                    '".$_REQUEST['num_operacion_wp_emp']."',
                    '".$cuota_num_tc."',
                    '".$_REQUEST['hora_voucher_emp']."',
                    '".$_REQUEST['nom_tc_emp']."'
                    )";

            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        }  
    }
    //----------
    // PAT
    //----------    
    if (in_array("pat_emp", $arr_check_emp)) {
        
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');
    
        $fill=false;
            $pdf->Cell(170,5,'PAT','LR',0,'L',1);
            $pdf->Ln();
    
            $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'ID PAT ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['id_pat_emp'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_pat_emp'].'.-','LR',0,'L',$fill);
            $pdf->Ln();
        
            $pdf->Cell(170,0,'','T');
            $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
            VALUES
            (
            ".$id_cp.",
            'PAT',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'EMP'
            )";
            //echo '[3]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $total_afectado=$stmt->rowCount();
            $id_fp = $con->lastInsertId();
        
        $sql="INSERT INTO intranet.pago
            (idforma_pago,
            monto,
            fecha_pago,
            num_documento,
            banco
            )VALUES(
            ".$id_fp.",
            ".str_replace(".","",$_REQUEST['monto_pat_emp']).",
            CURDATE(),
            '".$_REQUEST['id_pat_emp']."',
            ''
            )";
            //echo '[4]'.$sql.'<p>';
            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
        
    }
	//---------
    // OC
    //----------
	if (in_array("oc_emp", $arr_check_emp)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'Orden de Compra','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;
/*
        $pdf->Cell(25,5,'OC ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['text_oc_emp'].'.-','LR',0,'L',$fill);
        $pdf->Ln();
*/
        $pdf->Cell(25,5,'Rut Empresa ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['rut_empresa'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,'Razon Social ','LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['nombre_empresa']),'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(25,5,utf8_decode('Dirección '),'LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['direccion_empresa']),'LR',0,'L',$fill);
        $pdf->Ln();
/*
        $pdf->Cell(25,5,'Giro ','LR',0,'L',$fill);
        $pdf->Cell(145,5,utf8_decode($_REQUEST['giro_emp']),'LR',0,'L',$fill);
        $pdf->Ln();
*/
        $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['monto_oc_emp'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
            VALUES
            (
            ".$id_cp.",
            'Orden de Compra',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'EMP'	
            )";
            //echo '[9]'.$sql.'<p>';
            $fp = fopen("log_forma_pago.txt", "a");
            fwrite($fp, $sql);
            fclose($fp);

            $stmt = $con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $total_afectado=$stmt->rowCount();
            $id_fp = $con->lastInsertId();
        

        $sql="INSERT INTO intranet.pago
            (idforma_pago,
            monto,
            fecha_pago,
            num_documento,
            banco
            )VALUES(
            ".$id_fp.",
            ".str_replace(".","",$_REQUEST['monto_oc_emp']).",
            CURDATE(),
            '',
            ''
            )";

            $fp = fopen("log_forma_pago.txt", "a");
            fwrite($fp, $sql);
            fclose($fp);


        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();    


        $sql="INSERT INTO intranet.ordenes_compra_cp
            (id_postulacion, oc, rut, razon_social, direccion, giro, monto
            )VALUES(
            ".$id_postulacion.",
            '',
            '".$_REQUEST['rut_empresa']."',
            '".$_REQUEST['nombre_empresa']."',
            '".$_REQUEST['direccion_empresa']."',
            '',
            '".$_REQUEST['monto_oc_emp']."',
            )";

            $fp = fopen("log_forma_pago.txt", "a");
            fwrite($fp, $sql);
            fclose($fp);


        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(); 
    }
	
	//---------
    // Vale Vista
    //----------
	if (in_array("vv_emp", $arr_check_emp)) {
        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        //$pdf->SetFont('','B');
        $pdf->SetFont('Arial','B',8);

        $fill=false;
            $pdf->Cell(170,5,'Vale Vista','LR',0,'L',1);
            $pdf->Ln();

        $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['banco_vv_emp'],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$_REQUEST['monto_vv_emp'].'.-','LR',0,'L',$fill);
            $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
        $sql="INSERT INTO intranet.forma_pago
            (idcomprobante_pago,
            forma_pago,
            uf,
            descuento,
            total_a_pagar,
            atendido_por,
            fecha_atencion,
            fecha_ingreso,
            qpaga)
        VALUES
            (
            ".$id_cp.",
            'Vale Vista',
            '".$_REQUEST['uf']."',
            '".$_REQUEST['total_descuento']."',
            '".$_REQUEST['total_pagar']."',
            '".$_REQUEST['atendido']."',
            '".$_REQUEST['fecha_imp']."',
            NOW(),
            'INT'
        )";
        //echo '[3]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $total_afectado=$stmt->rowCount();
        $id_fp = $con->lastInsertId();
    
        $sql="INSERT INTO intranet.pago
        (idforma_pago,
        monto,
        fecha_pago,
        num_documento,
        banco
        )VALUES(
        ".$id_fp.",
        ".str_replace(".","",$_REQUEST['monto_vv_emp']).",
        CURDATE(),
        '',
        '".$_REQUEST['banco_vv_emp']."'
        )";
        //echo '[4]'.$sql.'<p>';
        $stmt = $con->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
    }

//-------------------------

$pdf->SetFont('Arial','B',8);
	$pdf->Cell(35,5,'% DESCUENTO ','0',0,'L');
	$pdf->SetFont('Arial');
	$pdf->Cell(80,5,': '.$_REQUEST['total_descuento'],'0',0,'L');
	$pdf->Ln(6);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,'UF','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5,': '.$_REQUEST['uf'],'0',0,'L');
$pdf->Ln(3);

//---------------
$monto_tx=isset($_REQUEST['monto_tx'])?str_replace(".","",$_REQUEST['monto_tx']):0;
$monto_tc=isset($_REQUEST['monto_tc'])?str_replace(".","",$_REQUEST['monto_tc']):0;
$monto_tc_wp=isset($_REQUEST['monto_tc_wp'])?str_replace(".","",$_REQUEST['monto_tc_wp']):0;
$monto_paypal=isset($_REQUEST['monto_paypal'])?str_replace(".","",$_REQUEST['monto_paypal']):0;
$monto_pat=isset($_REQUEST['monto_pat'])?str_replace(".","",$_REQUEST['monto_pat']):0;
$monto_pac=isset($_REQUEST['monto_pac'])?str_replace(".","",$_REQUEST['monto_pac']):0;
$monto_cuota_pac=isset($_REQUEST['monto_cuota_pac'])?str_replace(".","",$_REQUEST['monto_cuota_pac']):0;
$monto_oc=isset($_REQUEST['monto_oc'])?str_replace(".","",$_REQUEST['monto_oc']):0;
$monto_vv=isset($_REQUEST['monto_vv'])?str_replace(".","",$_REQUEST['monto_vv']):0;
$monto_tx_emp=isset($_REQUEST['monto_tx_emp'])?str_replace(".","",$_REQUEST['monto_tx_emp']):0;
$monto_tc_emp=isset($_REQUEST['monto_tc_emp'])?str_replace(".","",$_REQUEST['monto_tc_emp']):0;
$monto_tc_wp_emp=isset($_REQUEST['monto_tc_wp_emp'])?str_replace(".","",$_REQUEST['monto_tc_wp_emp']):0;
$monto_paypal_emp=isset($_REQUEST['monto_paypal_emp'])?str_replace(".","",$_REQUEST['monto_paypal_emp']):0;
$monto_pat_emp=isset($_REQUEST['monto_pat_emp'])?str_replace(".","",$_REQUEST['monto_pat_emp']):0;
$monto_oc_emp=isset($_REQUEST['monto_oc_emp'])?str_replace(".","",$_REQUEST['monto_oc_emp']):0;
$monto_vv_emp=isset($_REQUEST['monto_vv_emp'])?str_replace(".","",$_REQUEST['monto_vv_emp']):0;

$monto_tc_df = isset($monto_tc_df)?str_replace(".","",$monto_tc_df):0;

$total_pagar=$monto_tx+$monto_tc+$monto_tc_wp+$monto_paypal+$monto_pat+$monto_pac+$monto_cuota_pac+$monto_oc+$monto_vv+$monto_tx_emp+$monto_tc_emp+$monto_tc_wp_emp+$monto_paypal_emp+$monto_pat_emp+$monto_oc_emp+$monto_vv_emp + $monto_tc_df;


//echo $monto_tx.'+'.$monto_tc.'+'.$monto_tc_wp.'+'.$monto_paypal.'+'.$monto_pat.'+'.$monto_pac.'+'.$monto_cuota_pac.'+'.$monto_oc.'+'.$monto_vv.'+'.$monto_tx_emp.'+'.$monto_tc_emp.'+'.$monto_tc_wp_emp.'+'.$monto_paypal_emp.'+'.$monto_pat_emp.'+'.$monto_oc_emp.'+'.$monto_vv_emp .'+'. $monto_tc_df;
//echo '<p>'.$total_pagar;


$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,'Total','0',0,'L');
$pdf->SetFont('Arial');
$pdf->Cell(80,5,': $ '.number_format($total_pagar, 0, ",", ".").'.-','0',0,'L');
$pdf->Ln();
 
//------------------------------------------------------------

$pdf->Write(10,'Observacion: '.utf8_decode($_REQUEST['comentario']));
$pdf->Ln(10);

$pdf->Write(10,'ATENDIDO POR: '.$_REQUEST['atendido'].', FECHA: '.date('d-m-Y', strtotime($_REQUEST['fecha_imp'])));

$pdf->Ln(10);

/*
$pdf->Write(10,"____________________________");
$pdf->Ln(3);
$pdf->Write(10,utf8_decode("  Firma atención Ejecutivo"));
*/

//---------------------
if (in_array("tc", $arr_check_int) || in_array("webpay", $arr_check_int) || in_array("tc_emp", $arr_check_emp) || in_array("webpay_emp", $arr_check_emp) || in_array("webpay_diferido", $arr_check_int)) {
    $pdf->AddPage();

}
    //----------------------------------
    // Tarjeta Credito
    //----------------------------------
    if (in_array("tc", $arr_check_int)) {


        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial','B');

        $fill=false;
		$pdf->Cell(170,5,'Tarjeta Credito .','LR',0,'L',1);
		$pdf->Ln();

        $pdf->SetFont('');
		$fill=false;
		$pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['banco_tc'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		$pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['nom_tc'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		
		$pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_cuotas'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;

 	
        $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
        //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
        $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher'])).' '.$_REQUEST['hora_voucher'],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill=false;		
		
		
		$pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
		$pdf->Cell(145,6,$_REQUEST['monto_tc'].'.-','LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_operacion'],'LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Cod. verificacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['cod_autorizacion'],'LR',0,'L',$fill);
		$pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------
        
    }
    //----------------------------------
    // WEBPAY 
    //----------------------------------
    if (in_array("webpay", $arr_check_int)) {
        
        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'WEBPAY .','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;
        $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['banco_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['nom_tc_wp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
        $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_cuotas_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;

        
        
        $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
        //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
        $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_wp'])).' '.$_REQUEST['hora_voucher_wp'],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill=false;		
        
        
        $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,6,$_REQUEST['monto_tc_wp'].'.-','LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_operacion_wp'],'LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Codigo verificacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['cod_autorizacion_wp'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

    }

// EMPRESA

    //----------------------------------
    // Tarjeta Credito
    //----------------------------------
    if (in_array("tc_emp", $arr_check_emp)) {


        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial','B');

        $fill=false;
		$pdf->Cell(170,5,'Tarjeta Credito .','LR',0,'L',1);
		$pdf->Ln();

        $pdf->SetFont('');
		$fill=false;
		$pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['banco_tc_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;
		$pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['nom_tc_emp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;

        $cuota_num_tc=str_replace(".","",$_REQUEST['num_cuotas_emp']);
        
        if($cuota_num_tc=='' || $cuota_num_tc==0){$cuota_num_tc=1;}
		
		$pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$cuota_num_tc,'LR',0,'L',$fill);
		$pdf->Ln();
		$fill=false;

        $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
        //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
        $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_emp'])).' '.$_REQUEST['hora_voucher_emp'],'LR',0,'L',$fill);
        
        $pdf->Ln();
        $fill=false;		
		
		
		$pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
		$pdf->Cell(145,6,$_REQUEST['monto_tc_emp'].'.-','LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['num_operacion_emp'],'LR',0,'L',$fill);
		$pdf->Ln();
		
		$pdf->Cell(25,5,'Cod. verificacion ','LR',0,'L',$fill);
		$pdf->Cell(145,5,$_REQUEST['cod_autorizacion_emp'],'LR',0,'L',$fill);
		$pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

    }
    //----------------------------------
    // WEBPAY 
    //----------------------------------
    if (in_array("webpay_emp", $arr_check_emp)) {
        
        //Títulos de las columnas

        $pdf->SetFillColor(102,161,204);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(62,105,184);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('','B');

        $fill=false;
        $pdf->Cell(170,5,'WEBPAY .','LR',0,'L',1);
        $pdf->Ln();

        $pdf->SetFont('');
        $fill=false;
        $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['banco_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['nom_tc_wp_emp'].'  Numero: xxxx-xxxx-xxx-'.$_REQUEST['num_tc_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;
        
        $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_cuotas_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=false;

       
            $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
            //$pdf->Cell(145,5,$voucher_fecha,'LR',0,'L',$fill);
            $pdf->Cell(145,5, date('d-m-Y', strtotime($_REQUEST['fecha_voucher_wp_emp'])).' '.$_REQUEST['hora_voucher_wp_emp'],'LR',0,'L',$fill);
            
            $pdf->Ln();
            $fill=false;		
        
        
        $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
        $pdf->Cell(145,6,$_REQUEST['monto_tc_wp_emp'].'.-','LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['num_operacion_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();
        
        $pdf->Cell(25,5,'Codigo verificacion ','LR',0,'L',$fill);
        $pdf->Cell(145,5,$_REQUEST['cod_autorizacion_wp_emp'],'LR',0,'L',$fill);
        $pdf->Ln();

        $pdf->Cell(170,0,'','T');
        $pdf->Ln(3);
        //------------------------------------------------------

  
    }
    //-----------------


    //----------------------------------
    // WEBPAY DIFERIDO
    //----------------------------------
    if (in_array("webpay_diferido", $arr_check_int)) {


        $i=0;
       foreach($arr_num_tc_wp_df as $num_tc_wp_df){

            

            $pdf->SetFillColor(102,161,204);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(62,105,184);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('Arial','B');

            $fill=false;
            $pdf->Cell(170,5,'Tarjeta Credito '.($i+1),'LR',0,'L',1);
            $pdf->Ln();

            $pdf->SetFont('');
            $fill=false;
            $pdf->Cell(25,5,'Banco ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_banco_wp_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            $pdf->Cell(25,5,'Tarjeta ','LR',0,'L',$fill);
            $pdf->Cell(145,5,'Numero: xxxx-xxxx-xxx-'.$arr_num_tc_wp_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;
            
            $pdf->Cell(25,5,'Num. Cuota ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_num_cuotas_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            $fill=false;

        
            $pdf->Cell(25,5,'Fecha voucher','LR',0,'L',$fill);
           
            $pdf->Cell(145,5, date('d-m-Y H:i:s', strtotime($arr_fecha_voucher_df[$i])),'LR',0,'L',$fill);
            
            $pdf->Ln();
            $fill=false;		
            
            
            $pdf->Cell(25,6,'Monto ','LR',0,'L',$fill);
            $pdf->Cell(145,6,$arr_monto_tc_df[$i].'.-','LR',0,'L',$fill);
            $pdf->Ln();
            
            $pdf->Cell(25,5,'Num. Operacion ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_num_operacion_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();
            
            $pdf->Cell(25,5,'Cod. verificacion ','LR',0,'L',$fill);
            $pdf->Cell(145,5,$arr_cod_autorizacion_df[$i],'LR',0,'L',$fill);
            $pdf->Ln();

            $pdf->Cell(170,0,'','T');
            $pdf->Ln(3);
            //------------------------------------------------------
        $i++;
        }     
    }



    $sql="INSERT INTO intranet.postulacion_documentos
    (idpostulacion,
    documento,
    fecha_generacion)
    VALUES
    (
    '".$id_postulacion."',
    'comprobante_pago.pdf',
    NOW()
    )";

//echo '<pre>'.$sql.'</pre>';
//echo 'arr_numeral:<pre>'.print_r($arr_numeral, true).'</pre>';

$stmt_data = $con->prepare($sql);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();

//------------------





$dir_pdf = '/intranet/apps/admision_2021/dashboard/Fichas/'.$id_postulacion.'/';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/*

$strServer = "200.89.73.101";
$strServerPort = "4322";
$strServerUsername = "intranet";
$strServerPassword = "INtqwer55p.,";

$connection = ssh2_connect($strServer, $strServerPort);
ssh2_auth_password($connection, $strServerUsername, $strServerPassword);
    
$sftp = ssh2_sftp($connection);

if(!file_exists($dir_pdf)){
    ssh2_sftp_mkdir($sftp, $dir_pdf, 0777, true);
}

$pdfcode = $pdf->Output('S');
$archivo='comprobante_ingreso.pdf';
 
$stream = fopen("ssh2.sftp://$sftp$dir_pdf/$archivo", 'w');

fwrite($stream, $pdfcode);
fclose($stream); 


$dir_pdf2 = '/intranet/apps/cdg/postulacion/admision/Fichas/'.$id_postulacion.'/';
if(!file_exists($dir_pdf2)){
    ssh2_sftp_mkdir($sftp, $dir_pdf2, 0777, true);
}
$stream2 = fopen("ssh2.sftp://$sftp$dir_pdf2/$archivo", 'w');

fwrite($stream2, $pdfcode);
fclose($stream2); 



$connection = null; unset($connection);

$pdf->Output('I',$archivo);

*/
$dir_pdf='../../../../cdg/postulacion/admision/Fichas/'.$id_postulacion;
$dir_bk='../../../../cdg/postulacion/admision/Fichas/'.$id_postulacion.'/BK';

if (!file_exists($dir_pdf)) {
    mkdir($dir_pdf, 0777, true);
}elseif(file_exists($dir_pdf.'/comprobante_ingreso.pdf')){
    if (!file_exists($dir_bk)) {
        mkdir($dir_bk, 0777, true);
    }
    copy($dir_pdf.'/comprobante_ingreso.pdf',$dir_bk.'/'.date('ymdhis').'_comprobante_ingreso.pdf');
    unlink($dir_pdf.'/comprobante_ingreso.pdf');
}

$pdf->Output($dir_pdf.'/comprobante_ingreso.pdf','F');
$pdf->Output('I','comprobante_ingreso.pdf');

?>
