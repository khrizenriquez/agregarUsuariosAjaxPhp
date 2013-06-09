$(document).on("ready", textotTooltip);
$(document).on("ready", validandoCampos);
$(document).on("ready", cargandoImagen);
$(document).on("ready", abriendoVentanaModal);
$(document).on("ready", llamandoVentanas);
$(document).on("ready", validandoFormulario);

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
        var btnFirma = $('#btnGuardarDatos'), interval;

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