<?php
include('../src/conexion.php');
session_start();
error_reporting(0);
if(isset($_POST['submit']))
{
    $Fecha = $_POST['Fecha'];
    $Entrega = $_POST['Entrega'];
    //$Recibe = $_POST['Recibe'];

    $CC = $_POST['CC'];
    $CCTV = $_POST['CCTV'];
    $C_ACC = $_POST['C_ACC'];
    $Pabellones = $_POST['PAB'];
    $UPC = $_POST['UPC'];
    $P_Superiores = $_POST['P_Superiores'];
    $Incendio = $_POST['Incendio'];
    $Central_Termica = $_POST['Central_Termica'];
    $Data_Center = $_POST['Data_Center'];

    $Comentarios = $_POST['Comentarios'];
    $Observaciones = $_POST['Observaciones'];

    // Insertar nuevo registro
    $query = mysqli_query($con, "INSERT INTO Registro(Fecha, Entrega, CC, CCTV, C_ACC, PAB,
     UPC, P_Superiores, Incendio, Central_Termica, Data_Center, Comentarios, Observaciones) 
     VALUES('$Fecha', '$Entrega','$CC','$CCTV','$C_ACC' , '$Pabellones',
     '$UPC','$P_Superiores', '$Incendio', '$Central_Termica' , '$Data_Center', '$Comentarios' , '$Observaciones')");
         
    if ($query) {
        echo "Datos ingresados correctamente.";            
        echo "<script>window.location.href='index.php'</script>";
    } else {
        echo "Algo salió mal al insertar los datos. Inténtalo de nuevo.";
    }
}
?>