<?php
$id_form='00';

/*
# Definimos las variables
		//$strServer = "200.89.73.101";
		$strServer = "192.168.5.5";
		$strServerPort = "4322";
		$strServerUsername = "intranet";
		$strServerPassword = "INtqwer55p.,";		
		
		# Realizamos la conexion con el servidor
		$resConnection = ssh2_connect($strServer, $strServerPort);
		
		if(ssh2_auth_password($resConnection, $strServerUsername, $strServerPassword)){
			 
			$resSFTP = ssh2_sftp($resConnection);    
			
			//existe le directorio?
			if(!is_dir('../../../cdg/postulacion/admision/Fichas/'.$id_form)){
				 if(ssh2_sftp_mkdir($resSFTP, '/intranet/apps/cdg/postulacion/admision/Fichas/'.$id_form, 0775, true)){
					echo 'Directorio creado';
				 }else{
					echo 'Error';
				 };
			 }
	 
			
	 	
		}else{
			$msj_carga_archivo.= "No ha sido posible conectar con el servidor <br>";
		}
*/
// Desired directory structure
$structure = '../../../cdg/postulacion/admision/Fichas/'.$id_form;

// To create the nested structure, the $recursive parameter 
// to mkdir() must be specified.

if (!mkdir($structure, 0777, true)) {
    die('Failed to create directories...');
} else{
	echo 'Directorio creado';

	require('certinet/contratos/fpdf.php');

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

	$html = 'Ahora puede imprimir fácilmente texto mezclando diferentes estilos: <b>negrita</b>, <i>itálica</i>,
	<u>subrayado</u>, o ¡ <b><i><u>todos a la vez</u></i></b>!<br><br>También puede incluir enlaces en el
	texto, como <a href="http://www.fpdf.org">www.fpdf.org</a>, o en una imagen: pulse en el logotipo.';

	$pdf = new PDF();
	// Primera página
	$pdf->AddPage();
	$pdf->SetFont('Arial','',20);
	$pdf->Write(5,'Para saber qué hay de nuevo en este tutorial, pulse ');
	$pdf->SetFont('','U');
	$link = $pdf->AddLink();
	$pdf->Write(5,'aquí',$link);
	$pdf->SetFont('');
	// Segunda página
	$pdf->AddPage();
	$pdf->SetLink($link);
	$pdf->Image('../../img/1.jpg',10,12,30,0,'','http://www.fpdf.org');
	$pdf->SetLeftMargin(45);
	$pdf->SetFontSize(14);
	$pdf->WriteHTML($html);
	$pdf->Output($structure.'/archivo.pdf','F');
	
}       
?>