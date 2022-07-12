//REGISTRAR USUARIOS
function registrarUsuario(tipo){
    var url = "../testcastores/php/back.php/registrarUsuario";
    var usuario = $('#usuario').val();
    var password = $('#password').val();
    if (validarUsuario(usuario,password) == true){
        var data = {
            usuario : usuario,
            password: password,
            tipo    : tipo,
            accion  : "registro"
        };
        $.ajax({
            data: data,
            url: url,
            type: 'post',
            beforeSend: function () {
                $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
            },
            error: function(){
                      alert("error en la petición");
            },
            success: function(response){
                rdata = JSON.parse(response);
                if(rdata.success == 2){
                    Swal.fire(
                        'Registro Fallido',
                        'El usuario ya existe',
                        'error'
                    );
                }else if(rdata.success == 1){
                    Swal.fire(
                        'Registro Hecho',
                        'Se ha registrado el usuario',
                        'success'
                    );
                }else{
                    Swal.fire(
                        'Error con servidor',
                        'Hubo problemas al mandar la información, intente más tarde',
                        'error'
                    );
                }
                
            }
        });
    }
}

function validarUsuario(usuario,password){
    if(usuario.length == 0){
        $('#usuario').focus();
        return false;
    }else{
        if((usuario.length < 5) || (usuario.length > 20)){
            Swal.fire(
                'Error',
                'El nombre usuario debe ser de 5 a 20 caracteres!',
                'error'
            );
            $('#usuario').val('');
            $('#usuario').focus();
            return false;
        }else{
            if(password.length == 0){
                $('#password').focus();
                return false;
            }else{
                if((password.length < 8) || (password.length > 20)){
                    Swal.fire(
                        'Error',
                        'La contraseña debe ser de 8 a 20 caracteres!',
                        'error'
                    );
                    $('#password').val('');
                    $('#password').focus();
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
}

//LOG IN-OUT
function logIn(usuario_login,password_login){
    var url = "../testcastores/php/back.php/logIn";
    if (validarUsuario(usuario_login,password_login) == true){
        var data = {
            usuario : usuario_login,
            password: password_login,
            accion  : "login"
        };
        $.ajax({
            data: data,
            url: url,
            type: 'post',
            beforeSend: function () {
                $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
            },
            error: function(){
                      alert("error en la petición");
            },
            success: function(response){
                rdata = JSON.parse(response);
                if(rdata.success == 4){
                    Swal.fire(
                        'Error con Usuario',
                        'El usuario no coincide',
                        'error'
                    );
                }else if(rdata.success == 3){
                    Swal.fire(
                        'Error contraseña',
                        'La contraseña no coincide',
                        'error'
                    );
                }else if(rdata.success == 2){
                    Swal.fire(
                        'Log In',
                        'Inicio de Sesión Correcto',
                        'success'
                    );
                    setTimeout(() => {
                        location.replace('notas.php');
                    }, 5000);
                }else if(rdata.success == 1){
                    Swal.fire(
                        'Log In',
                        'Inicio de Sesión Correcto',
                        'success'
                    );
                    setTimeout(() => {
                        location.replace('admin.php');
                    }, 5000);
                    
                }else{
                    Swal.fire(
                        'Error con servidor',
                        'Hubo problemas al mandar la información, intente más tarde',
                        'error'
                    );
                }
                
            }
        });
    }
}

function logOut(){
    var url = "../testcastores/php/back.php/logOut";
    var data = {
        accion  : "logout"
    };
    $.ajax({
        data: data,
        url: url,
        type: 'post',
        beforeSend: function () {
            $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
        },
        error: function(){
                  alert("error en la petición");
        },
        success: function(response){
            rdata = JSON.parse(response);
            if(rdata.success == 1){
                Swal.fire(
                    'Log Out',
                    'Sesión Cerrada correctamente',
                    'success'
                );
                setTimeout(() => {
                    location.replace('notas.php');
                }, 5000);
            }else{
                Swal.fire(
                    'Error con servidor',
                    'Hubo problemas al mandar la información, intente más tarde',
                    'error'
                );
            }
            
        }
    });
}

//REGISTRAR NOTA

function registrarNota(titulo, nota){
    var url = "../testcastores/php/back.php/registrarNota";
    var titulo_nota = titulo;
    var nota_nota = nota;
    if (validarNota(titulo_nota,nota_nota) == true){
        var data = {
            titulo : titulo_nota,
            nota: nota_nota,
            accion  : "addNota"
        };
        $.ajax({
            data: data,
            url: url,
            type: 'post',
            beforeSend: function () {
                $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
            },
            error: function(){
                      alert("error en la petición");
            },
            success: function(response){
                rdata = JSON.parse(response);
                if(rdata.success == 1){
                    Swal.fire(
                        'Registro Hecho',
                        'La nota se ha creado correctamente!!',
                        'success'
                    );
                    $('#titulo_nota').val('');
                    $('#nota_nota').val('');
                }else{
                    Swal.fire(
                        'Error con servidor',
                        'Hubo problemas al mandar la información, intente más tarde',
                        'error'
                    );
                }
                
            }
        });
    }
}

function validarNota(titulo,nota){
    if(titulo.length == 0){
        $('#titulo_nota').focus();
        return false;
    }else{
        if((titulo.length < 5) || (titulo.length > 120)){
            Swal.fire(
                'Error',
                'El titulo debe ser de 5 a 120 caracteres!',
                'error'
            );
            $('#titulo_nota').val('');
            $('#titulo_nota').focus();
            return false;
        }else{
            if(nota.length == 0){
                $('#nota_nota').focus();
                return false;
            }else{
                if((nota.length < 20) || (nota.length > 512)){
                    Swal.fire(
                        'Error',
                        'La nota debe ser de 20 a 512 caracteres!',
                        'error'
                    );
                    $('#nota_nota').val('');
                    $('#nota_nota').focus();
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
}

function detalleNota(identificadorNota){
    var url = "../testcastores/php/back.php/detalleNota";
    var data = {
        idNota  : identificadorNota,
        accion  : "detalleNota"
    };
    $.ajax({
        data: data,
        url: url,
        type: 'post',
        beforeSend: function () {
            $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
        },
        error: function(){
                  alert("error en la petición");
        },
        success: function(response){
            Swal.fire(
                'Redireccionando',
                'Espere por favor...',
                'success'
            );
            setTimeout(() => {
                location.replace('notaDetalle.php');
            }, 3000);
        }
    });
}

function dejarComentario(comentario, iNota, iUsuarioSesion){
    var url = "../testcastores/php/back.php/registrarComentario";
    var data = {
        comentario      : comentario,
        idNota          : iNota,
        idUsuarioSesion : iUsuarioSesion,
        accion          : "registrarComentario"
    };
    if (validarComentario(comentario) == true){
        $.ajax({
            data: data,
            url: url,
            type: 'post',
            beforeSend: function () {
                $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
            },
            error: function(){
                      alert("error en la petición");
            },
            success: function(response){
                rdata = JSON.parse(response);
                if(rdata.success == 1){
                    setTimeout(() => {
                        location.replace('notaDetalle.php');
                    }, 3000);
                }else{
                    Swal.fire(
                        'Error con servidor',
                        'Hubo problemas al mandar la información, intente más tarde',
                        'error'
                    );
                }
                
            }
        });
    }
}

function validarComentario(comentario){
    if(comentario.length == 0){
        $('#dejarComentario').focus();
        return false;
    }else{
        if((comentario.length < 5) || (comentario.length > 250)){
            Swal.fire(
                'Error',
                'El comentario debe ser de 5 a 250 caracteres!',
                'error'
            );
            $('#dejarComentario').val('');
            $('#dejarComentario').focus();
            return false;
        }else{
            return true;
        }
    }
}

function dejarRespuesta(respuesta, icomentario, iUsuarioSesion){
    var url = "../testcastores/php/back.php/registrarRespuesta";
    var data = {
        respuesta       : respuesta,
        idComentario    : icomentario,
        idUsuarioSesion : iUsuarioSesion,
        accion          : "registrarRespuesta"
    };
    if (validarRespuesta(respuesta,icomentario) == true){
        $.ajax({
            data: data,
            url: url,
            type: 'post',
            beforeSend: function () {
                $("#camposregistrados").html("<p align='center'><img src='recursos/loadingIcon.gif' /></p>");
            },
            error: function(){
                      alert("error en la petición");
            },
            success: function(response){
                rdata = JSON.parse(response);
                if(rdata.success == 1){
                    setTimeout(() => {
                        location.replace('notaDetalle.php');
                    }, 3000);
                }else{
                    Swal.fire(
                        'Error con servidor',
                        'Hubo problemas al mandar la información, intente más tarde',
                        'error'
                    );
                }
                
            }
        });
    }
}

function validarRespuesta(respuesta,comentario){
    if(respuesta.length == 0){
        $('#dejarRespuesta_'+comentario+'').focus();
        return false;
    }else{
        if((respuesta.length < 5) || (respuesta.length > 250)){
            Swal.fire(
                'Error',
                'El respuesta debe ser de 5 a 250 caracteres!',
                'error'
            );
            $('#dejarRespuesta_'+comentario+'').val('');
            $('#dejarRespuesta_'+comentario+'').focus();
            return false;
        }else{
            return true;
        }
    }
}