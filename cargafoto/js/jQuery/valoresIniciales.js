$(document).on("ready", textotTooltip);
$(document).on("ready", validandoCampos);
$(document).on("ready", cargandoImagen);
$(document).on("ready", abriendoVentanaModal);
$(document).on("ready", llamandoVentanas);
$(document).on("ready", validandoFormulario);
$(document).on("ready", validandoNuevosRegistros);
$(document).on("ready", editandoArchivos);

var btnFirma = $('#btnGuardarDatos'), interval;
var btnGuardar = $('#btnRegistrarme'), interval;
var insertarOActualizar = false;
var accion_ok = 'noAccion';
//------------------------------------------------------------------------------coloca el tooltip a mis etiqutas
function textotTooltip()
{
    var tooltips = $( "[title]" ).tooltip();
}
//------------------------------------------------------------------------------coloca el tooltip a mis etiqutas

//------------------------------------------------------------------------------valida que los campos de usuario esten llenos cuando paso por ellos
function validandoCampos()
{
    if($('#txtNombreRegistro').blur())
    {
        if($('#fieldsetDatosUsuario > input[type]').val('') || $('#fieldsetDatosUsuario > input[type]').val() < 2)
        {
//            alert("no");
        }
    }
}
//------------------------------------------------------------------------------valida que los campos de usuario esten llenos cuando paso por ellos

//------------------------------------------------------------------------------agregando fotos
function cargandoImagen()
{
    $(function()
    {
        new AjaxUpload('#btnGuardarDatos', {
            action: 'scriptsPHP/subirFoto.php',
            onSubmit: function(file, ext){
                if(!(ext && /^(jpg|png)$/.test(ext)))//para que me permita extensiones jpg o png nada mas
                {
                    alert('Sube imagenes con extensión .jpg o png nada mas.');
                    return false;
                }else
                {
                    $('#divImgCargando').show();
                    btnFirma.html('<i class="icon-upload icon-white"></i>Espera por favor');
//                    btnFirma.text('Espera por favor');
                    this.disable();
                }
            },
            onComplete: function(file, response)
            {
                btnFirma.html('<i class="icon-camera icon-white"></i>Cargar foto');
//                btnFirma.text('Cargar foto');

                respuesta = $.parseJSON(response);//parceo lo que viene de php a json

                if(respuesta.respuesta == 'done')
                {
                    $('#imgFotoIndex').removeAttr('src');//remuevo la imagen por defecto

                    $('#imgFotoIndex').attr('src', 'img/imgSubidasTemporal/' + respuesta.fileName);
                    
                    $('#txtEscondido').attr('value', 'img/imgSubidasTemporal/' + respuesta.fileName);
                }else
                {
                    alert(respuesta.mensaje);
                }
                $('#divImgCargando').hide();

                this.enable();
            }
        });
    });
}
//------------------------------------------------------------------------------agregando fotos

//------------------------------------------------------------------------------ventana modal
//llamando a las funciones
function llamandoVentanas()
{
    $('#btnEditarIndex').on('click', editandoUsuariosIndex);//para editar
}

//llamando a editar
function editandoUsuariosIndex()
{
    $('#divEditarUsuariosIndex').dialog('open');
}
//llamando a editar
//llamando a nuestro div
function abriendoVentanaModal()
{
    $('#divEditarUsuariosIndex').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 'auto',
        height: 'auto',
        close: function()
        {
            $("#formEditarUsuarios input[type='text']").val('');
            $('#formEditarUsuarios fieldset > span').removeClass('error').empty();
        }
    });
}
//------------------------------------------------------------------------------ventana modal

//------------------------------------------------------------------------------validando formulario
function validandoFormulario()
{
    $('#formEditarUsuarios').validate({
        submitHandler: function()
        {
            var serializado = $('#formEditarUsuarios').serialize();
            alert(serializado);
            return false;
        },
        errorPlacement: function(error, element)
        {
            error.appendTo(element.prev('span').append());
        }
    });
}
//------------------------------------------------------------------------------validando formulario
//------------------------------------------------------------------------------validando que los datos esten llenos completamente
function validandoNuevosRegistros()
{
    $('#btnRegistrarme').click(function()//activo esta funcion cuando me salgo del foco de el campo direccion
    {
        if(insertarOActualizar == false)
        {
            if($("#txtNombreRegistro").val().length > 2 && $("#txtApellidosRegistro").val().length > 2 &&
                $("#txtUsuarioRegistro").val().length > 2 && $("#txtClaveRegistro").val().length > 2)
            {
                var str = $('#formIngresoDatos').serialize();
                $.ajax({
                    beforeSend: function(){
                      $('#divImgCargando').show();
                      btnGuardar.html('<i class="icon-upload icon-white"></i>Espera por favor');
                    },
                    cache: false,
                    type:'POST',
                    dataType: "json",
                    url:'scriptsPHP/guardarNuevosUsuarios.php',//esta es la direccion que me llevara al archivo para hacer las inserciones
//                        url:'scriptsPHP/insertTransDatosEmpleados.php',//esta es la direccion que me llevara al archivo para hacer las inserciones
                    //url:'insertar.php',//esta es la direccion que me llevara al archivo para hacer las inserciones
                    data: str + "&accion=addUser&id=" + Math.random(),
                    success: function(response)
                    {
//                        // Validar mensaje de error
                        if(response.respuesta == false)
                        {
                                alert(response.mensaje);
                        }
                        else
                        {
                            // si es exitosa la operación
//                            $('#agregarUser').dialog('close');
                            
                            btnGuardar.html('<i class="icon-ok icon-white"></i>Registrarme');
                            $('#divImgCargando').hide();
//                            if($('#sinDatos').length)
//                            {
//                                $('#sinDatos').remove();
//                            }
                            // Validad tipo de acción
                            if($('#accion').val() == 'editUser')
                            {
                                $('#listaUsuarios').empty();
                            }
                            $('#listaUsuarios').append(response.contenido);
                        }
                    }
                });
                return false;
            }else
            {
//                $('#lblMensajeVacio').fadeIn('slow').css('display', 'inline-block');
                return false;
            }
        }else
        {
//            alert("Ya estoy llena");
        }
    });
}
//------------------------------------------------------------------------------validando que los datos esten llenos completamente

//------------------------------------------------------------------------------editando valores de nuestra tabla
function editandoArchivos()
{
    $('body').on("click", '#listaUsuarios a', function(e){
        e.preventDefault();
        
        // Id Usuario
//        idUser_ok = $(this).attr('href');
        accion_ok = $(this).attr('data-accion');

//        $('#id_user').val(idUser_ok);
        $('#id_user').val(this).attr('href');

//        if(accion_ok == 'editar')
//        {
            // Valor de la acción
            $('#accion').val('editUser');

            // Llenar el formulario con los datos del registro seleccionado
            $('#txtNombreRegistroEditar').val($(this).parent().parent().children('td:eq(1)').text());
            $('#txtUsuarioRegistroEditar').val($(this).parent().parent().children('td:eq(2)').text());

            // Seleccionar status
//            $('#usr_status option[value='+ $(this).parent().parent().children('td:eq(3)').text() +']').attr('selected',true);

            // Abrimos el Formulario
            $('#agregarUser').dialog({
                    title:'Editar Usuario',
                    autoOpen:true
            });

        //}//else if($(this).attr('data-accion') == 'eliminar')
//        {
//            $('#dialog-borrar').dialog('open');
//        }
    });
}
//------------------------------------------------------------------------------editando valores de nuestra tabla