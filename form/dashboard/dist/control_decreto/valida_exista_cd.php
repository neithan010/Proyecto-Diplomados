<?php
include('../../cn/cn_PDO.php'); 

$id_postulacion='';
if(isset($_REQUEST['id_postulacion'])){
	$id_postulacion=$_REQUEST['id_postulacion'];
}
if($id_postulacion==''){
	echo 'Error';
	exit();
}

$dir_cp='../../Fichas/'.$id_postulacion.'/control_decreto.pdf';

if(file_exists($dir_cp)){
?>

    <div class="col" id="div_cd">
            <i class="fas fa-file-alt"></i>
            <a href="<?php echo $dir_cp.'?'.getrandmax();?>" target="_blank" id="lnk_cd">Control decreto</a>
            <i class="bi bi-download"></i> <i class="bi bi-trash" id="dell_cd"></i>
            
        </div>
<?php	
}else{
    ?>

    <div class="col" id="div_cd">
        <i class="fas fa-file-alt"></i>
        <a href="../control_decreto/control_decreto.php?id_postulacion=<?php echo $id_postulacion;?>" target="_blank" id="lnk_cd">Control decreto</a>
    </div>
<?php	
}


?>