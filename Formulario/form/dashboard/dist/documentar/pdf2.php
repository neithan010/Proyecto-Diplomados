<?php
include('../../../cn/cn_PDO.php');	

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

class PDF_HTML  extends FPDF
{
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
}


//$pdf = new PDF();
$pdf=new PDF_HTML();
// Primera página

$pdf->AddPage();
$pdf->SetFont('Times','',20);
//$pdf->selectFont('../include/fonts/Times-Roman.afm');
$pdf->SetFontSize(10);


$pdf->Image('marcaAgua2017.jpg',0,0,210);

$pdf->SetY(80);

while ($linea= fgets($fp,1024)){

    $texto = str_replace("!NOMBRE_COMPLETO!",strtoupper($nombre_completo),$linea);
    $texto = str_replace("!NR!",$rut,$texto);
    $texto = str_replace("!DIPLOMA!",strtoupper($programa),$texto);
}	

$texto='<p WIDTH="500px">'.utf8_decode($texto).'</p>';

$pdf->SetMargins(20,10,20);

$pdf->WriteHTML($texto);



$pdf->SetY(160);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'__________________________________',0,0,'C');
$pdf->Ln();
$texto=utf8_decode('FIRMA');
$pdf->Cell(0,10,$texto,0,0,'C');

$pdf->SetY(200);

$pdf->Cell(180,10,'Santiago, 26 de Agosto 2021.',0,0,'R');

$pdf->SetY(253);
$pdf->SetFont('Times','',8);
$pdf->Cell(185,10,'unegocios.uchile.cl',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(185,10,'Diagonal Paraguay 257, Piso 9, of. 903, Santiago Chile.',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(185,10,'Tel.: (56 2) 29783380 - E-mail: contacto@unegocios.cl',0,0,'R');




$pdf->Output();
?>