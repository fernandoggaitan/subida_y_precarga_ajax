<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Subir archivos </title>
        <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="js/upload.js"></script>
        <script type="text/javascript">
            function subirArchivos() {
                $("#archivo").upload('subir_archivo.php',
                        {
                            nombre_archivo: $("#nombre_archivo").val()
                        },
                function(respuesta) {
                    //Subida finalizada.
                    $("#barra_de_progreso").val(0);
                    if (respuesta === 1) {
                        alert('El archivo ha sido subido correctamente.');
                        $("#nombre_archivo, #archivo").val('');
                    } else {
                        alert('El archivo NO se ha podido subir.');
                    }
                    mostrarArchivos();
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $("#barra_de_progreso").val(valor);
                });
            }
            function eliminarArchivos(archivo) {
                $.ajax({
                    url: 'eliminar_archivo.php',
                    type: 'POST',
                    timeout: 10000,
                    data: {archivo: archivo},
                    error: function() {
                        alert('Error al intentar eliminar el archivo.');
                    },
                    success: function(respuesta) {
                        if (respuesta == 1) {
                            alert('El archivo ha sido eliminado.');
                            mostrarArchivos();
                        } else {
                            alert('Error al intentar eliminar el archivo.');
                        }
                    }
                });
            }
            function mostrarArchivos() {
                $.ajax({
                    url: 'mostrar_archivos.php',
                    dataType: 'JSON',
                    success: function(respuesta) {
                        if (respuesta) {
                            var lista = $("'<ul></ul>'");
                            for (var i = 0; i < respuesta.length; i++) {
                                if (respuesta[i] != undefined) {
                                    lista.append('<li> <span> ' + respuesta[i] + ' </span> | <a class="eliminar_archivo" href="javascript:void(0);"> Eliminar </a> </li>');
                                }
                            }
                            $("#archivos_subidos").html(lista);
                        }
                    }
                });
            }
            $(document).ready(function() {
                mostrarArchivos();
                $("#boton_subir").on('click', function() {
                    subirArchivos();
                });
                $("#archivos_subidos").on('click', '.eliminar_archivo', function() {
                    var archivo = $(this).parents('li').find('span').text();
                    archivo = $.trim(archivo);
                    eliminarArchivos(archivo);
                });
            });
        </script>
    </head>
    <body>
        <form action="javascript:void(0);">
            <label> Nombre el archivo: </label>
            <input type="text" name="nombre_archivo" id="nombre_archivo" />
            <input type="file" name="archivo" id="archivo" />
            <br />
            <input type="submit" id="boton_subir" value="Subir" />
            <br />
            <progress id="barra_de_progreso" value="0" max="100"></progress>
        </form>
        <div id="archivos_subidos"></div>
    </body>
</html>