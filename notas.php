<?php
    include('cabecera.php');
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    date_default_timezone_set('America/Mexico_City');
    if(isset($_SESSION['session_username'])){
        $session = "select * from usuario where usuario = '".$_SESSION['session_username']."' AND TipoUsuario > 0";
        $session = $conn->query($session);
        $session = $session->fetch_assoc();
?>
<div class="container section">
    <h2>Noticias</h2>
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
        <?php if($session['TipoUsuario'] == 1) echo "<li><a href='admin.php'><i class='material-icons'>assessment</i>Dashboard</a></li>"; ?>
        <li><a href="#!" onclick="logOut()"><i class="material-icons">keyboard_return</i>Cerrar Sesión</a></li>
    </ul>
    <div class="row">
        <div id="loader" class="text-center"><div class="preloader-wrapper active">
            <div class="spinner-layer spinner-red-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
            </div>
        </div></div>
		<div class="outer_div"></div>
    </div>
</div>
<?php }else{?>
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
                    <button class="btn waves-effect waves-light" type="submit" onclick = "registrarUsuario(2)" name="action">Registrar
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