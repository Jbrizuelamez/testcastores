<?php
$conn = mysqli_connect('localhost','root','','testcastores');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//CREAR USUARIOS
if($_POST['accion'] == 'registro'){
    if (isset($_POST['usuario']) && $_POST['password'] && isset($_POST['tipo'])) {
        $usuario    = $_REQUEST["usuario"];
        $password   = $_REQUEST["password"];
        $tipo       = $_REQUEST["tipo"];
        //PROCESAMIENTO DE DATOS
        $buscarUsuario      = "SELECT Usuario from usuario where usuario ='".$usuario."'";
        $buscarUsu          = $conn->query($buscarUsuario);
        $resultadoBusqueda  = $buscarUsu->fetch_assoc();
        
        if(!empty($resultadoBusqueda['Usuario'])){
            echo json_encode(array('success' => 2));
        }else{
            //INSERCIÓN DE DATOS
            $query = "INSERT INTO usuario (Usuario,Password,TipoUsuario) VALUES ('$usuario','".md5($password)."',$tipo)";
            if(mysqli_query($conn, $query)){
                echo json_encode(array('success' => 1));
            }else{
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('success' => 0));
    }
}

if($_POST['accion'] == 'login'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (isset($_POST['usuario']) && isset($_POST['password'])){
        $usuario_login  = $_REQUEST["usuario"];
        $password_login = $_REQUEST["password"];
        //PROCESAMIENTO DE DATOS
        $buscarUsuario  = "SELECT Usuario from usuario where usuario = '".$usuario_login."'";
        $buscarUsu      = $conn->query($buscarUsuario);
        $resultadoBusquedaUsu = $buscarUsu->fetch_assoc();

        $encryptPassword    = md5($password_login);
        $buscarPassword     = "SELECT password from usuario where usuario = '".$usuario_login."' AND password = '".$encryptPassword."'";
        $buscarPass         = $conn->query($buscarPassword);
        $resultadoBusquedaPass = $buscarPass->fetch_assoc();

        if(empty($resultadoBusquedaUsu['Usuario'])){
            echo json_encode(array('success' => 4));
        }else{
            if(empty($resultadoBusquedaPass['password'])){
                echo json_encode(array('success' => 3));
            }else{
                $_SESSION['session_username']=$usuario_login;
                $sesion = $conn->query("select * from usuario where usuario = '".$_SESSION['session_username']."'");
                $sesion = $sesion->fetch_assoc();
                if ($sesion['TipoUsuario'] == 2) {
                    echo json_encode(array('success' => 2));                    
                }elseif($sesion['TipoUsuario'] == 1){
                    echo json_encode(array('success' => 1));                    
                }else{
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }
            }
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('success' => 0));
    }
}

if($_POST['accion'] == 'logout'){
    if(session_status()){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_destroy();
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}

//REGISTRAR NOTA
if($_POST['accion'] == 'addNota'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (isset($_POST['titulo']) && isset($_POST['nota'])){
        $titulo_nota    = $_REQUEST['titulo'];
        $nota_nota      = $_REQUEST['nota'];
        // echo json_encode(array('success' => $titulo_nota.' '.$nota_nota));
        //PROCESAR DATOS
        $buscarUsuarioParaNota = $conn->query("SELECT * FROM usuario where Usuario = '".$_SESSION['session_username']."'");
        $buscarUsuarioParaNota = $buscarUsuarioParaNota->fetch_assoc();
        $fecha  = date("Y-m-d");
        $hora   = date("H:i:s");

        //INSERCIÓN DE DATOS
        $query  = "INSERT INTO nota (Titulo,Nota,Fecha,Hora,idUsuario) VALUES ('".$titulo_nota."','".$nota_nota."','".$fecha."','".$hora."',".$buscarUsuarioParaNota['idUsuario'].")";
        if(mysqli_query($conn, $query)){
            echo json_encode(array('success' => 1));
        }else{
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('success' => 0));
    }
}

if($_POST['accion'] == 'detalleNota'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    $_SESSION['IDENTIFICADORNOTA']  = $_POST["idNota"];
}

//REGISTRAR COMENTARIOS
if($_POST['accion'] == 'registrarComentario'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    $_SESSION['IDENTIFICADORNOTA']  = $_POST["idNota"];
    if (isset($_POST['comentario']) && isset($_POST['idNota']) && isset($_POST['idUsuarioSesion'])){
        $comentario         = $_REQUEST['comentario'];
        $idNota             = $_REQUEST['idNota'];
        $idUsuarioSesion    = $_REQUEST['idUsuarioSesion'];
        // echo json_encode(array('success' => $titulo_nota.' '.$nota_nota));
        //PROCESAR DATOS
        $buscarUsuarioParaNota = $conn->query("SELECT * FROM usuario where Usuario = '".$idUsuarioSesion."'");
        $buscarUsuarioParaNota = $buscarUsuarioParaNota->fetch_assoc();
        $fecha  = date("Y-m-d");
        $hora   = date("H:i:s");

        //INSERCIÓN DE DATOS
        $query  = "INSERT INTO comentarios (Comentario,Fecha,Hora,idUsuario,idNota) VALUES ('".$comentario."','".$fecha."','".$hora."',".$buscarUsuarioParaNota['idUsuario'].",".$idNota.")";
        if(mysqli_query($conn, $query)){
            echo json_encode(array('success' => 1));
        }else{
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('success' => 0));
    }
}

//REGISTRAR RESPUESTA
if($_POST['accion'] == 'registrarRespuesta'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (isset($_POST['respuesta']) && isset($_POST['idComentario']) && isset($_POST['idUsuarioSesion'])){
        $respuesta          = $_REQUEST['respuesta'];
        $idComentario       = $_REQUEST['idComentario'];
        $idUsuarioSesion    = $_REQUEST['idUsuarioSesion'];
        // echo json_encode(array('success' => $titulo_nota.' '.$nota_nota));
        //PROCESAR DATOS
        $buscarUsuarioParaNota = $conn->query("SELECT * FROM usuario where Usuario = '".$idUsuarioSesion."'");
        $buscarUsuarioParaNota = $buscarUsuarioParaNota->fetch_assoc();
        $fecha  = date("Y-m-d");
        $hora   = date("H:i:s");

        //INSERCIÓN DE DATOS
        $query  = "INSERT INTO respuestas (Respuesta,Fecha,Hora,idUsuario,idComentario) VALUES ('".$respuesta."','".$fecha."','".$hora."',".$buscarUsuarioParaNota['idUsuario'].",".$idComentario.")";
        if(mysqli_query($conn, $query)){
            echo json_encode(array('success' => 1));
        }else{
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('success' => 0));
    }
}

//PAGINACIÓN
if($_POST['accion'] == 'cargarPaginacion'){
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    include 'pagination.php';
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    $per_page = 3;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;
    $count_query = $conn->query("SELECT count(*) AS numrows FROM nota");
    if ($row = mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
    $total_pages = ceil($numrows/$per_page);
    $reload = '../notas.php';
    $obtenerNotas = $conn->query("SELECT n.idNota, n.Titulo, n.Nota, n.Fecha, n.Hora, u.Usuario, u.TipoUsuario FROM nota n
    JOIN usuario u ON n.idUsuario = u.idUsuario ORDER BY n.idNota LIMIT $offset,$per_page");
    if($numrows > 0){
        while ($row = $obtenerNotas->fetch_assoc()) {
            ?>
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                        <img src="images/breaking-news.jpg">
                        <span class="card-title"><?php echo $row['Titulo'] ?></span>
                        </div>
                        <div class="card-content">
                        <p class="-b-expander -b-text-undexpanded"><?php echo $row['Nota'] ?></p>
                        <p>Creado por: <?php echo $row['Usuario'] ?> <?php if($row['TipoUsuario'] == 1){ echo '<span class="new badge blue">interno</span>'; }else{ echo '<span class="new badge blue">externo</span>'; } ?></p>
                        <p>Fecha: <?php echo $row['Fecha'] ?> y Hora: <?php echo $row['Hora'] ?></p>
                        </div>
                        <div class="card-action">
                        <a href="#!" onclick="detalleNota(<?php echo $row['idNota'] ?>)"><i class="material-icons">import_contacts</i>Ver Nota</a>
                        </div>
                    </div>
                </div>
    <?php } ?>
    <ul class="pagination">
        <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
    </ul>
    <?php
    }else{
        ?>
        <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>Aviso!!!</h4> No hay datos para mostrar
        </div>
    <?php
    }

}
?>