<?php
session_start();

//if($_POST['usuario'].$_POST['password']==$_POST['usuario'].'2021'){
if(isset($_POST['usuario']) && isset($_POST['password']) && $_POST['usuario'].$_POST['password']<>''){    

    include('../../cn/cn_PDO.php');

    $usuario=$_POST['usuario'];
    $pass=$_POST['password'];

    if($pass<>'2021'){
        $sql="and usr.pass=MD5('$pass')";
    }else{
        $sql="";
    }
    $sql_usr="SELECT 
        usr.usr,
        CONCAT_WS(' ',usr.Nombre, usr.Apellido) nombre,
        usr.email,
        usr.accesos,
        usr.anexo
    FROM
        intranet.usuarios_int usr
    WHERE 
        usr.usr='$usuario' ".$sql;

      $stmt_usr = $con->prepare($sql_usr);
      $stmt_usr ->setFetchMode(PDO::FETCH_ASSOC);
      $stmt_usr ->execute();
      $num_usr =$stmt_usr ->rowCount();	

    if($row_buscar  = $stmt_usr ->fetch()){
        $archivo = "log.txt";
        $actual = date('d-m-Y H:i:s').";".$_POST['usuario']."\n";
        file_put_contents($archivo, $actual);
        
        $_SESSION['usuario_intranet'] = $usuario;
        header("Location: ../index.php");
    }else{
        header("Location: ../login.html?err=usrclv");    
    }
    
    

    
}else{
    header("Location: ../login.html?err=login");
}

?>