<?php
$arr_url = explode("/",$_SERVER["REQUEST_URI"]);
$arr_link = explode("?",end($arr_url));
$link = $arr_link[0];
//echo $link;
?>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_aceptadas.php")?'active':''; ?> bg-success bg-opacity-10" aria-current="page"
            href="programas_all_aceptadas.php">Aceptadas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_brouchure.php")?'active':''; ?> "
            href="programas_all_brouchure.php">Brouchure</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_pre_postulacion.php")?'active':''; ?>"
            href="programas_all_pre_postulacion.php">Pre Postulacion</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_nuevas.php")?'active':''; ?>"
            href="programas_all_nuevas.php">Nuevas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_evaluacion.php")?'active':''; ?>"
            href="programas_all_evaluacion.php">En Evaluación</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_rechazadas.php")?'active':''; ?>"
            href="programas_all_rechazadas.php">Rechazadas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_pendientes.php")?'active':''; ?>"
            href="programas_all_pendientes.php">Pendientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($link=="programas_all_eliminadas.php")?'active':''; ?>"
            href="programas_all_eliminadas.php">Eliminadas</a>
    </li>
</ul>

<form action="#" name="frm_periodo" id="frm_periodo" method="POST">
    <div class="row align-items-start p-3">
        <div class="col-3">Semestre:
            <select class="form-select form-select-sm " id="periodo" name="periodo" aria-label=".form-select-sm ">
                <option selected>Seleccione un semestre</option>
                <?php foreach($arr_periodos as $periodo_cmb){ ?>
                <option value="<?php echo $periodo_cmb;?>" <?php if($periodo_cmb==$periodo){echo 'selected';} ?>>
                    <?php echo $periodo_cmb;?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-9"></div>
    </div>
</form>
<!--
<div class="row align-items-start p-3">
<div class="col-7">
Filtrar en todas: <input type="text" name="" id="filtrar">
</div>
        <div class="col-5"></div>
</div>
                -->
        <div class="row align-items-start p-3">
        <div class="col-7">Programas:
            <select class="form-select form-select-sm " id="cmb_programa" name="cmb_programa" aria-label=".form-select-sm ">
                <option selected>Seleccione un Programa</option>
                <option value="">Mostrar Todos los programas </option>
                                            <?php
foreach($arr_programas as $programa){
?>
                <option value="<?php echo $programa['id_programa'];?>" >
                    <?php echo $programa['programa'];?></option>
<?php } ?>
            </select>
        </div>
        <div class="col-5"></div>
    </div>