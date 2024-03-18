<?php
function limpiar_caracteres_especiales($s) {
	//$s = str_replace("Ió","O",$s);

	$s = ereg_replace("[����]","a",$s);
	$s = ereg_replace("[����]","A",$s);
	$s = ereg_replace("[���]","e",$s);
	$s = ereg_replace("[���]","E",$s);
	$s = ereg_replace("[���]","i",$s);
	$s = ereg_replace("[���]","I",$s);
	//$s = ereg_replace("[�����]","o",$s);
	$s = ereg_replace("[����]","O",$s);
	$s = ereg_replace("[���]","u",$s);
	$s = ereg_replace("[���]","U",$s);
//	$s = str_replace(" ","_",$s);
	$s = str_replace("�","n",$s);
	$s = str_replace("�","o",$s);
	$s = str_replace("�","N",$s);
	$s = str_replace("�","",$s);

	
	
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
} 


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

function ChapterBody($file1,$file2){
/* 
 	require_once('../../../../../../Connections/cn_intranet.php'); 
	//require_once('Connections/cn_intranet.php');
	mysql_select_db($database_cn_intranet, $cn_intranet);

	$sql= "
		SELECT 
		  p.ID_POSTULACION,
		  UCASE(p.POSTULACION) POSTULACION,
		  UCASE(p.NOMBRES) NOMBRES,
		  UCASE(p.APELLIDO_PAT) APELLIDO_PAT,
		  UCASE(p.APELLIDO_MAT) APELLIDO_MAT,
		  p.RUT,
		  concat(UCASE(p.DIREC_PARTICULAR),', ',UCASE(c.nombre)) direccion,
		  UCASE(p.CARRERA_PRO) CARRERA_PRO,
		  DATE_FORMAT(d.fecha_inicio,'%d-%m-%Y') mes_inicio,
		  ROUND(d.valor_diplomado,0) valor_diplomado
FROM
	unegocios_nuevo.postulacion p left join unegocios_nuevo.comunas c on p.comuna=c.cod_comuna
	left join intranet.diplomados d on p.cod_diploma=d.cod_diploma
WHERE
	  p.ID_POSTULACION =".$_REQUEST['ID'];

//echo $sql.'<p>';
	$rs_sql = mysql_query($sql, $cn_intranet) or die(mysql_error());
	$row_rs_sql = mysql_fetch_assoc($rs_sql);
*/

	//$diploma=$row_rs_sql['POSTULACION'];
	$diploma=$_REQUEST['diploma'];
	$diploma=limpiar_caracteres_especiales($diploma);

	//$nombre_completo=$row_rs_sql['NOMBRES'].' '.$row_rs_sql['APELLIDO_PAT'].' '.$row_rs_sql['APELLIDO_MAT'];
	$nombre_completo=$_REQUEST['nombre_completo'];
    // Leemos el fichero
    $txt = file_get_contents($file1);

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
/*
$fecha=$_REQUEST['fecha_imp'];
$fecha_imp=substr($fecha,0,2). ' de';
$fecha_imp.=mes_es($fecha);
$fecha_imp.=substr($fecha,6,4);
*/

$fecha_imp=$_REQUEST['fecha_imp'];
/*
$rut=$row_rs_sql['RUT'];
$rut1=substr($rut,0,strlen($rut)-2);
$rut1=number_format($rut1, 0, ",", ".");
$dv=substr($rut,-2);
$rut=$rut1.$dv;
*/
$rut=$_REQUEST['RUT'];
		
	$txt = str_replace("!FECHA!",$fecha_imp,$txt);
	$txt = str_replace("!NOMBRE_COMPLETO!",strtoupper($nombre_completo),$txt);
	$txt = str_replace("!RUT!",$rut,$txt);
	$txt = str_replace("!NACIONALIDAD!",$_REQUEST['NACIONALIDAD'],$txt);
	
	$txt = str_replace("!DIPLOMA!",strtoupper(limpiar_caracteres_especiales($row_rs_sql['POSTULACION'])),$txt);	
	$txt = str_replace("!PROFESION!",strtoupper($_REQUEST['CARRERA_PRO']),$txt);	
	$txt = str_replace("!DOMICILIO!",strtoupper($_REQUEST['DIREC_PARTICULAR']),$txt);	
	$txt = str_replace("!PROGRAMA!",strtoupper($_REQUEST['diploma']),$txt);
	$txt = str_replace("!INICIO_PROGRAMA!",strtoupper($_REQUEST['ini_programa']),$txt);
	$txt = str_replace("!VALOR_PROGRAMA!",$_REQUEST['valor_programa'],$txt);

	$txt = str_replace("!INICIO_NIVELACION!",strtoupper($_REQUEST['ini_nivelacion']),$txt);
	 
	
    // Times 12
    $this->SetFont('times','',10);
    // Imprimimos el texto justificado
    $this->MultiCell(0,5,$txt);
	$this->Ln();
	//--------------------------------------
	//Cuadro
	$this->SetWidths(array(95,95));
	$this->Row(array('Plazo en que se efect�a la comunicaci�n de retiro de
Diploma en que el alumno se matricul�.','Valor a pagar a la Universidad por costos de
materiales, administraci�n y operacionales.'));
 
 $this->Row(array('Hasta quince d�as corridos antes del inicio del diploma.','5 UF'));

 $this->Row(array('Faltando menos de quince d�as corridos y hasta el d�a de inicio del diplomado.','15 UF'));

	  $this->Row(array('Desde el inicio de clases del diplomado en adelante.','Deber� pagar el proporcional de las horas cursadas sobre el arancel total, siendo la proporci�n m�nima de pago, un 25% del arancel indicado total del diploma respectivo.'));
	 
	//-------------
	$txt = file_get_contents($file2);
	
	$this->MultiCell(0,5,$txt);
    // Salto de l�nea
    $this->Ln();
    // Cita en it�lica
    $this->SetFont('','I');
    //$this->Cell(0,5,'(fin del extracto)');
}

function PrintChapter($num, $title, $file, $file2)
{
    $this->AddPage();
	$this->SetFont('times','BU',11);
	$this->Cell(0,10,'CONTRATO DE PRESTACI�N DE SERVICIOS EDUCACIONALES',0,1,'C',false);
	//$this->ChapterTitle($num,$title);
    $this->ChapterBody($file, $file2);
	
	$this->SetFont('times','B',10);

	$variableY = $this->GetY();
	$variableX = $this->GetX();

	$this->SetY($variableY+10);
	$this->SetX($variableX+20);
	
	$this->MultiCell(55,5,'MANUEL AGOSIN TRUMPER Decano',0,'C',false);
	
	$variableY = $this->GetY();
	$variableX = $this->GetX();

	$this->SetY($variableY-10);
	$this->SetX($variableX+100);
	
	$this->MultiCell(55,5,'__________________________ Alumno',0,'C',false);

}
}

$pdf = new PDF();
//$pdf->AddPage();

// Salto de l�nea
$pdf->Ln(1);
$title='CONTRATO DE PRESTACI�N DE SERVICIOS EDUCACIONALES';
//$pdf->SetTitle($title);
//$pdf->SetAuthor('Julio Verne');
$pdf->PrintChapter(1,'','contrato_prestacion_servicio_DGIS_p1.txt','contrato_prestacion_servicio_DGIS_p2.txt');



//$pdf->PrintChapter(2,'LOS PROS Y LOS CONTRAS','20k_c2.txt');
$pdf->Output();
?>