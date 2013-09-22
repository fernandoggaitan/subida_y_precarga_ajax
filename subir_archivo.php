<?php

if (isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombre = "{$_POST['nombre_archivo']}.$extension";
    $nombre = $nombre;
    if (move_uploaded_file($archivo['tmp_name'], "archivos_subidos/$nombre")) {
        echo 1;
    } else {
        echo 0;
    }
}

?>