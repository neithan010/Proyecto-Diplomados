<?php
include('../../cn/cn_PDO.php');	

$id_postulacion=$_REQUEST['form_id'];

$sql_postulante="SELECT 
d.DIPLOMADO as programa,
CONCAT_WS(' ',p.NOMBRES,p.APELLIDO_PAT,	p.APELLIDO_MAT) nombre_completo,
p.RUT,
p.cod_diploma
FROM 
unegocios_nuevo.postulacion p 
INNER JOIN intranet.diplomados d ON p.cod_diploma=d.cod_diploma
WHERE 
p.ID_POSTULACION=". $id_postulacion;

//echo '<pre>'.$sql_postulante.'</pre>';

$stmt_postulante = $con->prepare($sql_postulante);
$stmt_postulante ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_postulante ->execute();
$num_postulantea =$stmt_postulante ->rowCount();	
//echo '::'.$num_postulantea;

if ($rw_data  = $stmt_postulante ->fetch()){
    $programa           = mb_strtoupper(utf8_encode($rw_data['programa']));
    $nombre_completo    = mb_strtoupper(utf8_encode($rw_data['nombre_completo']));
    $rut                = $rw_data['RUT'];
    $cod_diploma        = $rw_data['cod_diploma'];
    
}

//echo $programa;
//exit();


//--------------------------------------------------
// TEXTO diplomas con apuntes de nievelacion
//--------------------------------------------------
$array_nivelacion=array('XX','DF','DIMF','DAE','DEAE','DGCo','DMV','DDM','DMR','DGDCo','DMDCE', 'DICDM','DGCD');

$arr_cod_diploma=explode(".",$cod_diploma);



if(array_search($arr_cod_diploma[0],$array_nivelacion)>0){ 
    $fp = fopen("cartas/declaracion_apuntes.txt","r");
}elseif($arr_cod_diploma[0]=='DP'){
    $fp = fopen("cartas/declaracion_DGPro.txt","r");
}elseif($arr_cod_diploma[0]=='DEGP'){
    $fp = fopen("cartas/declaracion_DEGP.txt","r");
}else{
    $fp = fopen("cartas/declaracion.txt","r");
}

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
}


$pdf = new PDF();
// Primera página

$pdf->AddPage();
$pdf->SetFont('Times','B',20);

$pdf->SetFontSize(10);


$pdf->Image('marcaAgua2017.jpg',0,0,210);
$pdf->SetY(40);
$texto = utf8_decode("DECLARACIÓN");

$pdf->Cell(0,10,$texto,0,0,'C');


$pdf->SetMargins(20,10,20);
$pdf->SetY(60);

while ($linea= fgets($fp,1024)){

    $texto = str_replace("!NOMBRE_COMPLETO!",strtoupper($nombre_completo),$linea);
    $texto = str_replace("!NR!",$rut,$texto);
    $texto = str_replace("!DIPLOMA!",strtoupper($programa),$texto);
}	

$texto='<p align="justify">'.utf8_decode($texto).'</p>';

$pdf->WriteHTML($texto);

$pdf->SetY(160);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'__________________________________',0,0,'C');
$pdf->Ln();
$texto=utf8_decode('FIRMA');

$pdf->Cell(0,10,$texto,0,0,'C');

$pdf->SetY(200);

$pdf->Cell(170,10,'Santiago, 26 de Agosto 2021.',0,0,'R');

$pdf->SetY(253);
$pdf->SetFont('Times','',8);
$pdf->Cell(175,10,'unegocios.uchile.cl',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(175,10,'Diagonal Paraguay 257, Piso 9, of. 903, Santiago Chile.',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(175,10,'Tel.: (56 2) 29783380 - E-mail: contacto@unegocios.cl',0,0,'R');


$nombre_pdf='declaracion_'.$id_postulacion.'.pdf';
$pdf->Output('D',$nombre_pdf);
//$aux=$pdf->Output('S','declaracion');


/*
$aux=base64_encode($aux);

//-------------------------------------------------------------------------------------
// Guardo Base
//-------------------------------------------------------------------------------------
$form_id=$_REQUEST['form_id'];


	
if($form_id!=''){
//echo $aux;	

	$query = 'INSERT INTO intranet.firma_digital 
				(id_postulacion,declaracion_64, fecha) 
			values 
				("'.$form_id.'","'.$aux.'", NOW()) 
			ON DUPLICATE KEY UPDATE 
				declaracion_64="'.$aux.'", 
				fecha=NOW()';
		//echo $query.'<p>';
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
	//mysql_free_result($result);

//-------------
	$dir='../Fichas/'.$_REQUEST["ID"].'/';
	if(!is_dir($dir)){
		//mkdir($dir, 0, true);
		mkdir($dir, 0777);
	}else{
		chmod($dir, 0777);
	}
	
	$fp=fopen('../Fichas/'.$_REQUEST["ID"].'/declaracion_jurada.pdf','wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	$sql="INSERT INTO intranet.postulacion_documentos
			(idpostulacion,
			documento,
			fecha_generacion)
			VALUES
			(
			'".$_REQUEST["ID"]."',
			'declaracion_jurada.pdf',
			NOW()
			)";

	mysql_query($sql) or die('Consulta fallida: ' . mysql_error());

	echo 'Declaracion Generada. ';
//-------------	
}else{
	echo 'ERROR';
}

*/
?>
