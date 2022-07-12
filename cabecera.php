<?php
    include_once('conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/materialize.css" media="screen,projection">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <script src="js/jquery.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script>
        function errorZone(){
            Swal.fire(
                'Alto',
                'Usted no tiene autorización de estar en esta zona, se redireccionará a la correspondiente',
                'warning'
            );
            setTimeout(() => {
                location.replace('notas.php');
            }, 5000);
        }
    </script>
</head>
<body>