<?php
    include('cabecera.php');
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    date_default_timezone_set('America/Mexico_City');
    if(isset($_SESSION['session_username']) && isset($_SESSION['IDENTIFICADORNOTA'])){
        $session = "select * from usuario where usuario = '".$_SESSION['session_username']."' AND TipoUsuario > 0";
        $session = $conn->query($session);
        $session = $session->fetch_assoc();
        if((empty($session['TipoUsuario']))){
?>
            <script>
                errorZone();
            </script>
<?php
        }else{
            $obtenerNotas = $conn->query("SELECT n.idNota, n.Titulo, n.Nota, n.Fecha, n.Hora, u.Usuario FROM nota n
            JOIN usuario u ON n.idUsuario = u.idUsuario WHERE idNota = ".$_SESSION['IDENTIFICADORNOTA']);
            $obtenerNotas = $obtenerNotas->fetch_assoc();
?>
            <div class="container section">
                <a href="#" class="sidenav-trigger btn-floating btn-large waves-effect waves-light red" data-target="menu-side">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="sidenav collapsible" id="menu-side">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img src="images/background-menuside.jpg" alt="">
                            </div>
                            <a href="#">
                                <img src="images/236831.png" alt="" class="circle">
                            </a>
                            <a href="">
                                <?php
                                    if(empty($session['Usuario'])){
                                        echo "<span class='name white-text'>Usuario: Anónimo </span>";
                                    }else{
                                        echo "<span class='name white-text'>Usuario: ".$session['Usuario']."</span>";
                                    }
                                ?>
                            </a>
                        </div>
                    </li>
                    <li><a href="#!" onclick="logOut()"><i class="material-icons">keyboard_return</i>Cerrar Sesión</a></li>
                </ul>
                <br>
                <div class="row">
                    <div class="col s12">
                        <blockquote>
                            <h1><?php echo $obtenerNotas['Titulo'] ?></h1>
                        </blockquote>
                        <p>Creado por: <?php echo $obtenerNotas['Usuario'] ?>            Fecha: <?php echo $obtenerNotas['Fecha'] ?></p>
                        <div class="divider"></div>
                        <h5><?php echo $obtenerNotas['Nota'] ?></h5> 
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <blockquote>
                            <h6>Comentarios</h6>
                        </blockquote>
                        <div class="row">
                            <div class="input-field col s12">
                            <textarea id="dejarComentario" class="materialize-textarea"></textarea>
                            <label for="dejarComentario">Comentario</label>
                            </div>
                        </div>
                        <div class="col s6 m6">
                            <button class="btn waves-effect waves-light" type="submit" onclick = "dejarComentario($('#dejarComentario').val(),<?php echo $_SESSION['IDENTIFICADORNOTA'] ?>, '<?php echo $_SESSION['session_username'] ?>')" name="action">Comentar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <div class="col s12 m12">
                            <br>
                            <div class="divider"></div>
                            <br>
                            <ul class="collapsible">
                            <?php
                                $obtenerComentarios = $conn->query("SELECT c.idComentario, c.Comentario, c.Fecha, c.Hora, u.Usuario, u.TipoUsuario FROM comentarios c
                                JOIN usuario u ON c.idUsuario = u.idUsuario
                                JOIN nota n ON c.idNota = n.idNota
                                WHERE c.idNota = ".$_SESSION['IDENTIFICADORNOTA']);
                                while ($rowComentario = $obtenerComentarios->fetch_assoc()) {
                            ?>
                                <li>
                                    <div class="collapsible-header">
                                        <div class="row valign-wrapper">
                                            <div class="col s2">
                                                <img src="images/236831.png" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                                            </div>
                                            <div class="col s10">
                                                <p><strong>User: <?php echo $rowComentario['Usuario'] ?></strong> <?php if($rowComentario['TipoUsuario'] == 1){ echo '<span class="new badge blue">interno</span>'; }else{ echo '<span class="new badge blue">externo</span>'; } ?></p>
                                                <span class="black-text">
                                                    <?php echo $rowComentario['Comentario'] ?>
                                                </span>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="collapsible-body">
                                    <?php
                                        $obtenerRespuestas = $conn->query("SELECT r.Respuesta, r.Fecha, r.Hora, u.Usuario, u.TipoUsuario FROM respuestas r
                                        JOIN usuario u ON r.idUsuario = u.idUsuario
                                        JOIN comentarios c ON r.idComentario = c.idComentario
                                        WHERE r.idComentario = ".$rowComentario['idComentario']);
                                        while ($rowRespuesta = $obtenerRespuestas->fetch_assoc()) {
                                    ?>
                                        <div class="card-panel grey lighten-5 z-depth-1">
                                            <div class="row valign-wrapper">
                                                <div class="col s2">
                                                    <img src="images/236831.png" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                                                </div>
                                                <div class="col s10">
                                                    <p><strong>User: <?php echo $rowRespuesta['Usuario'] ?></strong> <?php if($rowRespuesta['TipoUsuario'] == 1){ echo '<span class="new badge blue">interno</span>'; }else{ echo '<span class="new badge blue">externo</span>'; } ?></p>
                                                    <span class="black-text">
                                                    <?php echo $rowRespuesta['Respuesta'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <blockquote>
                                                <h6>Responde:</h6>
                                            </blockquote>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                <textarea id="dejarRespuesta_<?php echo $rowComentario['idComentario'] ?>" class="materialize-textarea"></textarea>
                                                <label for="dejarRespuesta">Respuesta</label>
                                                </div>
                                            </div>
                                            <div class="col s6 m6">
                                                <button class="btn waves-effect waves-light" type="submit" onclick = "dejarRespuesta($('#dejarRespuesta_<?php echo $rowComentario['idComentario'] ?>').val(), <?php echo $rowComentario['idComentario'] ?>, '<?php echo $_SESSION['session_username'] ?>')" name="action">Comentar
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
<?php   }
    }
    include('pie.php');
?>