<?php require_once('../../cn/cn_PDO.php'); ?>
<?php
$cod_diploma=isset($_REQUEST['cod_diploma'])?$_REQUEST['cod_diploma']:'';

if($cod_diploma==''){
    echo 'Error';
    exit();
}


/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */

/*--------------------------------------------------------------------------------
-----------------------------------------------------------------------------------*/


$sql_pre_post="select
	d.usr_cordinador_ad, 
	p.ID_POSTULACION, 
	p.cod_diploma, 
	p.POSTULACION, 
	p.NOMBRES, 
	p.APELLIDO_PAT, 
	p.APELLIDO_MAT, 
	p.RUT,
	p.EMAIL, 
	p.email_laboral,
	p.CELULAR,
	p.TELEFONO,	
	date_format(p.FECHA_POST,'%d-%m-%Y %H:%i:%s') FECHA_POST,
	(SELECT GROUP_CONCAT(DISTINCT concat(p.POSTULACION,' - ',p2.cod_diploma) SEPARATOR ',') as matriculado   FROM unegocios_nuevo.postulacion p2 WHERE p2.RUT=p.RUT AND CONCAT(p2.etapa,p2.estado) IN (3030,3131,4020)) AS otro_programa
from 
	unegocios_nuevo.postulacion p 
	inner join intranet.diplomados d on p.cod_diploma=d.cod_diploma
where
	-- d.Periodo in (select periodo from intranet.periodos p where p.vigente_adm=1) and 
	CONCAT(p.etapa, p.estado) IN ('1010') 
	and d.cod_diploma like '".$cod_diploma."'

order by p.NOMBRES";


// echo '<pre>'.$sql_pre_post.'</pre>';


$stmt_pre_post = $con->prepare($sql_pre_post);
$stmt_pre_post->setFetchMode(PDO::FETCH_ASSOC);
$stmt_pre_post->execute();
$totalRows_rs_matriculados=$stmt_pre_post->rowCount();	


function texto_html($str){

	$arr_letras=array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","ü","Ñ","Ü");
	$arr_html=array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&ntilde;","&uuml;","&Ntilde;","&Uuml;");
	$rp=str_replace($arr_letras, $arr_html, $str);
	//
	return $rp;
}


/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Santiago');


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../../Classes/PHPExcel.php';

// PHPExcel_IOFactory
include '../../../../../Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load('template.xlsx');

// Set document properties
$objPHPExcel->getProperties()->setCreator("Docencia - Centro de Desarrollo Gerencial")
							 ->setLastModifiedBy("Docencia CDG")
							 ->setTitle("Asistencia")
							 ->setSubject("Office 2007 XLSX Asistencia")
							 ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php. [Llevio]")
							 ->setCategory("Admision");


// Add some data
$objPHPExcel->getActiveSheet()->SetCellValue('D2','Pre postulaciones');
$objPHPExcel->getActiveSheet()->SetCellValue('D3','');
$objPHPExcel->getActiveSheet()->SetCellValue('D4',"");


$fila=1;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$fila, 'ID POSTULACION')
            ->setCellValue('B'.$fila, 'COD DIPLOMA')
            ->setCellValue('C'.$fila, 'POSTULACION')
            ->setCellValue('D'.$fila, 'NOMBRES')
            ->setCellValue('E'.$fila, 'APELLIDO PAT')
			->setCellValue('F'.$fila, 'APELLIDO MAT')
			->setCellValue('G'.$fila, 'RUT')
			->setCellValue('H'.$fila, 'EMAIL')
			->setCellValue('I'.$fila, 'EMAIL LABORAL')
			->setCellValue('J'.$fila, 'CELULAR')
			->setCellValue('K'.$fila, 'TELEFONO')
			->setCellValue('L'.$fila, 'FECHA POSTULACION')
			->setCellValue('M'.$fila, 'MATRICULADO OTRO PROGRAMA')
			;
			
	$i=0;
	$cont_fecha=0;
	$objPHPExcel->setActiveSheetIndex(0);
	$porcentaje_final=0;



$styleArray = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			//'color' => array('argb' => '00DDDDDD'),
			'color' => array('argb' => '00000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->getStartColor()->setARGB('FFC0C0C0');

$cont=$fila+1;
$objPHPExcel->setActiveSheetIndex(0);

$n_alumno=1;
while ($row_rs_matriculados = $stmt_pre_post->fetch()){

	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$cont, $row_rs_matriculados['ID_POSTULACION'])
            ->setCellValue('B'.$cont, utf8_encode($row_rs_matriculados['cod_diploma']))
            ->setCellValue('C'.$cont, utf8_encode($row_rs_matriculados['POSTULACION']))
            ->setCellValue('D'.$cont, utf8_encode($row_rs_matriculados['NOMBRES']))
			->setCellValue('E'.$cont, utf8_encode($row_rs_matriculados['APELLIDO_PAT']))
			->setCellValue('F'.$cont, utf8_encode($row_rs_matriculados['APELLIDO_MAT']))
			->setCellValue('G'.$cont, $row_rs_matriculados['RUT'])
			->setCellValue('H'.$cont, $row_rs_matriculados['EMAIL'])
			->setCellValue('I'.$cont, $row_rs_matriculados['email_laboral'])
			->setCellValue('J'.$cont, $row_rs_matriculados['CELULAR'])
			->setCellValue('K'.$cont, $row_rs_matriculados['TELEFONO'])
			->setCellValue('L'.$cont, $row_rs_matriculados['FECHA_POST'])
			->setCellValue('M'.$cont, utf8_encode($row_rs_matriculados['otro_programa']))
			;
			


	$n_alumno++;

	//$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+70).$cont, 'Hola ::',0);
	 
	$cont++;
	
	
} 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Eliminados');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$nombre_archivo='asistencia';
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Eliminados '.$cod_diploma.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
