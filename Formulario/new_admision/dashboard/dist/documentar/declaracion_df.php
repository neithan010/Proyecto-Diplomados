<?php
include('../../cn/cn_PDO.php');	

$id_postulacion=$_REQUEST['form_id'];

$texto_declaracion=$_REQUEST['texto_declaracion'];
$fecha_imp=$_REQUEST['fecha_imp'];

//echo $programa;
//exit();

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

$pdf->SetFont('Times','',10);
$texto='<p align="justify">'.utf8_decode($texto_declaracion).'</p>';

$pdf->WriteHTML($texto);

$pdf->SetY(160);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'__________________________________',0,0,'C');
$pdf->Ln();
$texto=utf8_decode('FIRMA');

$pdf->Cell(0,10,$texto,0,0,'C');

$pdf->SetY(200);

$pdf->Cell(170,10,'Santiago, '.$fecha_imp.'.',0,0,'R');

$pdf->SetY(253);
$pdf->SetFont('Times','',8);
$pdf->Cell(175,10,'unegocios.uchile.cl',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(175,10,'Diagonal Paraguay 257, Piso 9, of. 903, Santiago Chile.',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(175,10,'Tel.: (56 2) 29783380 - E-mail: contacto@unegocios.cl',0,0,'R');


//---------------------


$sql_data="INSERT INTO intranet.postulacion_data_pagos
(id_postulacion, declaracion_jurada)
VALUES
($id_postulacion, 1)
ON DUPLICATE KEY UPDATE
declaracion_jurada = 1
";

$stmt_data = $con->prepare($sql_data);
$stmt_data ->setFetchMode(PDO::FETCH_ASSOC);
$stmt_data ->execute();
$num_stmt_data =$stmt_data ->rowCount();

//------------------

//$nombre_pdf='declaracion.pdf';

$dir_pdf = '/intranet/apps/admision_2021/dashboard/Fichas/'.$id_postulacion.'/';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

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
$archivo='declaracion_jurada.pdf';
 
$stream = fopen("ssh2.sftp://$sftp$dir_pdf/$archivo", 'w');

fwrite($stream, $pdfcode);
fclose($stream); 




$pdf->Output('I',$archivo);


?>
