<?php
error_reporting(0);

?>
<?php
require('fpdf.php');

class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function ChapterBody($file1,$file2,$file3){

	$diploma=$_REQUEST['diploma'];
	

	//$nombre_completo=$row_rs_sql['NOMBRES'].' '.$row_rs_sql['APELLIDO_PAT'].' '.$row_rs_sql['APELLIDO_MAT'];
	$nombre_completo=utf8_decode($_REQUEST['nombre_completo']);
    // Leemos el fichero
    $txt = file_get_contents($file1);
	$txt = utf8_decode($txt);

function mes_es($fecha){
	switch(substr($fecha,3,2)){
		case '01':
			$fecha_imp=' Enero ';
			break;
		case '02':
			$fecha_imp=' Febrero ';
			break;
		case '03':
			$fecha_imp=' Marzo ';
			break;
		case '04':
			$fecha_imp=' Abril ';
			break;
		case '05':
			$fecha_imp=' Mayo ';
			break;
		case '06':
			$fecha_imp=' Junio ';
			break;
		case '07':
			$fecha_imp=' Julio ';
			break;
		case '08':
			$fecha_imp=' Agosto ';
			break;
		case '09':
			$fecha_imp=' Septiembtre ';
			break;
		case '10':
			$fecha_imp=' Octubre ';
			break;
		case '11':
			$fecha_imp=' Noviembre ';
			break;
		case '12':
			$fecha_imp=' Diciembre ';
			break;
	}
	return $fecha_imp;
}
$fecha_imp=$_REQUEST['fecha_imp'];

$rut=$_REQUEST['RUT'];
		
	$txt = str_replace("!FECHA!",$fecha_imp,$txt);
	$txt = str_replace("!NOMBRE_COMPLETO!",$nombre_completo,$txt);
	$txt = str_replace("!RUT!",$rut,$txt);
	$txt = str_replace("!NACIONALIDAD!",utf8_decode($_REQUEST['NACIONALIDAD']),$txt);
	
	$txt = str_replace("!DIPLOMA!",mb_strtoupper(utf8_decode($_REQUEST['diploma'])),$txt);	
	$txt = str_replace("!PROFESION!",mb_strtoupper(utf8_decode($_REQUEST['CARRERA_PRO'])),$txt);	
	$txt = str_replace("!DOMICILIO!",mb_strtoupper(utf8_decode($_REQUEST['DIREC_PARTICULAR'])),$txt);	
	$txt = str_replace("!PROGRAMA!",mb_strtoupper(utf8_decode($_REQUEST['diploma'])),$txt);
	$txt = str_replace("!INICIO_PROGRAMA!",mb_strtoupper($_REQUEST['ini_programa']),$txt);
	$txt = str_replace("!VALOR_PROGRAMA!",$_REQUEST['valor_programa'],$txt);
	$txt = str_replace("!MONEDA!",$_REQUEST['moneda'],$txt);
	
	$txt = str_replace("!year_inicio!",$_REQUEST['year_inicio'],$txt);
	
	$txt = str_replace("!TITULO_DECANO!",$_REQUEST['titulo_decano'],$txt);
	$txt = str_replace("!RUT_DECANO!",$_REQUEST['rut_decano'],$txt);
	$txt = str_replace("!NOMBRE_DECANO!",$_REQUEST['nombre_decano'],$txt);
	
	

	//$txt = str_replace("!INICIO_NIVELACION!",strtoupper($_REQUEST['ini_nivelacion']),$txt);
	
	if($_REQUEST['quien_paga']!=''){
		if($_REQUEST['quien_paga']=='alumno'){
			$quienPaga='X';
			}
		elseif($_REQUEST['quien_paga']=='su_empresa'){
			$quienPaga_ae='X';
			$descto_empresa=$_REQUEST['descuento_su_empresa'];	
		}elseif($_REQUEST['quien_paga']=='alumno_empresa'){
			$quienPaga_dae='X';	
			$descto_alum_empr=$_REQUEST['descuento_alum_empresa'];
		} 
	}
    // Times 12
    $this->SetFont('times','',10);
    // Imprimimos el texto justificado
    $this->MultiCell(0,5,$txt);
	$this->Ln();
	
$arr_cod_diploma=explode(".",$_REQUEST['cod_diploma']);
$periodo_mod=$arr_cod_diploma[1].$arr_cod_diploma[2];
	
	//--------------------------------------
	// C u a d r o   1
	//--------------------------------------

	$this->SetWidths(array(20,170));
		 
	$this->Row(array(''.$quienPaga.'','Por el alumno en su totalidad.'));
	
	$this->Row(array(''.$quienPaga_ae.'','Por su empleador en su totalidad, para lo cual el Alumno entrega en este acto Orden de Compra y/o Carta de Compromiso de su empleador.'));
	
	$this->Row(array(''.$quienPaga_dae.'',utf8_decode('En parte por su empleador y en parte por el Alumno, para lo cual éste entrega en este acto Orden de Compra y/o Carta de Compromiso de su empleador, e indica en qué porcentajes será pagado el programa por cada uno de ellos.')));
		 
	$this->Ln();
	$txt = file_get_contents($file3);
	$txt = utf8_decode($txt);

	$this->SetFont('times','',10);
	$this->MultiCell(0,5,$txt);
	// Salto de l�nea
	//$this->Ln();
	 
	//$this->AddPage();
	   
	//--------------------------------------
	// C u a d r o   2
	//--------------------------------------
/*
	$this->SetWidths(array(95,95));
	$this->Row(array('i ','Para programas que tengan una duración superior a 1 mes, quedarán exentos del pago del 100% del arancel, siempre y cuando la renuncia se realice antes o dentro de la primera semana de iniciadas las clases.'));
 
	$this->Row(array('ii ','En el caso de los alumnos que soliciten la renuncia fundada con posterioridad a la primera semana de iniciadas las clases, se les podrá rebajar el remanente del arancel, en la proporción correspondiente al tiempo que falte para el término del programa, para lo cual deberán adjuntar los antecedentes que le sirvan de respaldo.'));

	$this->Row(array('iii ','Para aquellos programas que tengan una duración inferior a 1 mes, podrán quedar exentos del pago del 100% del arancel, siempre y cuando la renuncia se realice antes de iniciadas las clases.'));
*/
	

	$txt = file_get_contents($file2);
	$txt = utf8_decode($txt);
	

	$this->MultiCell(0,5,$txt);
    // Salto de l�nea
    $this->Ln();
    // Cita en it�lica
    $this->SetFont('','I');
    //$this->Cell(0,5,'(fin del extracto)');
}

function PrintChapter($num, $title, $file, $file2, $file3)
{
    $this->AddPage();
	$this->SetFont('times','BU',11);
	$this->Cell(0,10,utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCACIONALES'),0,1,'C',false);

    $this->ChapterBody($file, $file2, $file3);
	
	$this->SetFont('times','B',10);

	$variableY = $this->GetY();
	$variableX = $this->GetX();


	$this->SetY($variableY+10);

	
	$this->MultiCell(85,5,strtoupper($_REQUEST['nombre_decano']),0,'C',false);
	$this->MultiCell(85,5,strtoupper($_REQUEST['titulo_decano']),0,'C',false);
	$this->MultiCell(85,5,utf8_decode('FACULTAD DE ECONOMÍA Y NEGOCIOS'),0,'C',false);
	$this->MultiCell(85,5,'UNIVERSIDAD DE CHILE',0,'C',false);
	
	
	$variableY = $this->GetY();
	$variableX = $this->GetX();

	$this->SetY($variableY-20);
	$this->SetX($variableX+100);
	
	$this->MultiCell(55,5,'__________________________ ALUMNO',0,'C',false);

}
}

$pdf = new PDF();


// Salto de l�nea
$pdf->Ln(1);
$title='CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCACIONALES';


/*** contrato para diplomas inferiores a 2016S1 ***/
$arr_cod_diploma=explode(".",$_REQUEST['cod_diploma']);
$periodo_num=$arr_cod_diploma[1].$arr_cod_diploma[2];


	$pdf->PrintChapter(1,'','contrato_prestacion_servicio_p1.txt','contrato_prestacion_servicio_p2.txt','contrato_prestacion_servicio_p3.txt');


//$pdf->PrintChapter(2,'LOS PROS Y LOS CONTRAS','20k_c2.txt');

$sql="INSERT INTO intranet.postulacion_documentos
		(idpostulacion,
		documento,
		fecha_generacion)
		VALUES
		(
		'".$form_id."',
		'contrato_servicio.pdf',
		NOW()
		)";

	//echo '<pre>'.$sql.'</pre>';
	//echo 'arr_numeral:<pre>'.print_r($arr_numeral, true).'</pre>';
	
	$stmt_data = $con->prepare($sql);
	$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
	$stmt_data ->execute();

//$pdf->Output($dir_pdf.'/Contrato_servicio.pdf','F');

$dir_pdf = '/intranet/apps/admision_2021/dashboard/Fichas/'.$form_id.'/';

$strServer = "200.89.73.101";
$strServerPort = "4322";
$strServerUsername = "intranet";
$strServerPassword = "INtqwer55p.,";

$connection = ssh2_connect($strServer, $strServerPort);
ssh2_auth_password($connection, $strServerUsername, $strServerPassword);
    
$sftp = ssh2_sftp($connection);

if(!file_exists($dir_pdf)){
    ssh2_sftp_mkdir($sftp, $dir_pdf);
}

$pdfcode = $pdf->Output('S');
$archivo='contrato_servicio.pdf';
 
$stream = fopen("ssh2.sftp://$sftp$dir_pdf/$archivo", 'w');

fwrite($stream, $pdfcode);
fclose($stream); 




$pdf->Output('I',$archivo);
?>