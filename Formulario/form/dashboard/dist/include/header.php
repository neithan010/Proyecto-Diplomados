<?php
if($_SESSION["usuario_intranet"]==''){
    header("Location: ../dist/include/cerrar_session.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - WEB</title>
    <link href="css/styles.css" rel="stylesheet" />
    <!--
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
 CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <link href="css/estilo2.css" rel="stylesheet" />

    <link rel="stylesheet" href="../../css/loading-bar.css">
    <!--<link rel="stylesheet" href="../../css/mini_pace.css">-->

    <!--<script src="../../js/pace.min.js"></script>-->

    <script data-pace-options='{ "ajax": false }' src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js">
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light  bg-light ">
        <img src="../../img/firma-2020.png" alt="" height="24" class="d-inline-block align-text-top">
        <a class="navbar-brand" href="index.php">Intranet</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <!--    
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                    -->
            </div>
        </form>
        <!-- Navbar-->
        <div class="dropdown">
            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?php echo $_SESSION['usuario_intranet'];?> <i class="fas fa-user fa-fw"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="include/cerrar_session.php">Salir</a></li>
               <!-- <li><a class="dropdown-item" href="#">Perfil</a></li>-->

            </ul>
        </div>
    </nav>
    <div id="layoutSidenav">

        <?php include_once('include/menu_izq.php');?>

        <div id="layoutSidenav_content">
            <main>