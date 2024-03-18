<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../include/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdfcode = $pdf->Output('S');

//echo $pdfcode;
//exit();



$nombre_pdf='declaracion.pdf';
$id_postulacion='000';
$dir_pdf = '/intranet/apps/admision_2021/dashboard/Fichas/'.$id_postulacion.'/';



$strServer = "200.89.73.101";
$strServerPort = "4322";
$strServerUsername = "intranet";
$strServerPassword = "INtqwer55p.,";

$connection = ssh2_connect($strServer, $strServerPort);
ssh2_auth_password($connection, $strServerUsername, $strServerPassword);
    
$sftp = ssh2_sftp($connection);

if(!file_exists($dir_pdf)){
    //if(!mkdir($dir_pdf, 0777)){
    ssh2_sftp_mkdir($sftp, $dir_pdf, 0777, true);
		
}

//$pdf->Output('../../Fichas/'.$id_postulacion.'/declaracion_jurada.pdf','F');

//$localFile='/files/myfile.zip';

//$pdfcode = $pdf->Output("", "S");
//$pdf->Output('../../Fichas/'.$id_postulacion.'/declaracion_jurada.pdf','F');

 
$stream = fopen("ssh2.sftp://$sftp$dir_pdf/$nombre_pdf", 'w');
//$pdf->Output('$dir_pdf/$nombre_pdf','F');

//$file = file_get_contents($pdfcode);
fwrite($stream, $pdfcode );
fclose($stream); 

?>