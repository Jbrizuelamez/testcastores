<?php
    include('cabecera.php');
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    date_default_timezone_set('America/Mexico_City');
    if(isset($_SESSION['session_username'])){
        $session = "select * from usuario where usuario = '".$_SESSION['session_username']."' AND TipoUsuario = 1";
        $session = $conn->query($session);
        $session = $session->fetch_assoc();
        if((empty($session['TipoUsuario']))){
?>
            <script>
                errorZone();
            </script>
<?php
        }else{
?>
            <div class="container section">
                <h2>Dashboard</h2>
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
                    <li><a href="notas.php"><i class="material-icons">collections_bookmark</i>Notas</a></li>
                    <li><a href="admin.php"><i class="material-icons">assessment</i>Dashboard</a></li>
                    <li><a href="#!" onclick="logOut()"><i class="material-icons">keyboard_return</i>Cerrar Sesión</a></li>
                </ul>
                <div class="modal-cuadro row">

                    <a class="waves-effect waves-light btn modal-trigger" href="#modal1"><i class="material-icons">add_box</i> Crear Nota</a>

                    <!-- Modal Structure -->
                    <div id="modal1" class="modal">
                    <div class="modal-content">
                        <h4>Generando Nota</h4>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="titulo_nota" type="text">
                            <label for="titulo_nota">Título</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                            <textarea id="nota_nota" class="materialize-textarea"></textarea>
                            <label for="nota_nota">Nota</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="registrarNota($('#titulo_nota').val(),$('#nota_nota').val());">Crear Nota</a>
                    </div>
                    </div>
                </div>
            </div>
<?php   }
    }else{
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
                        if(empty($sesion['usuario'])){
                            echo "<span class='name white-text'>Usuario: Anónimo </span>";
                        }else{
                            echo "<span class='name white-text'>Usuario:".$sesion['usuario']."</span>";
                        }
                    ?>
                </a>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">account_box</i>Registrar Usuario</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12">
                        <input id="usuario" type="text">
                        <label for="usuario">Usuario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                        <input id="password" type="password" class="validate">
                        <label for="password">Contraseña</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" onclick = "registrarUsuario(1)" name="action">Registrar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">keyboard_tab</i>Iniciar Sesión</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="row">
                        <div class="input-field col s12">
                        <input id="usuario_login" type="text">
                        <label for="usuario_login">Usuario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                        <input id="password_login" type="password" class="validate">
                        <label for="password_login">Contraseña</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" onclick = "logIn($('#usuario_login').val(),$('#password_login').val())" name="action">LogIn
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                
            </div>
        </li>
    </ul>
</div>
<?php
    }
    include('pie.php');
?>