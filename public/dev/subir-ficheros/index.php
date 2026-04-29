<center><br><br>
        <a href="index.php"><h1>Inicio</h1></a>
        <br><br>  
        
        
<form id="update_profile" method="post" action="" enctype="multipart/form-data">
  <input type="file" name="video_usuario" />
  <input type="submit" value="Save" />
</form>        

 <!-- <input type="hidden" name="MAX_FILE_SIZE" value="314572800" />-->
        <!-- Página de conversión de MB y bytes ques es lo que recibe como parámetro el campo MAX_FILE_SIZE -->
        <!-- 314572800 bytes son 300MB -->
        <!-- 1048576   bytes son 1MB-->
        
        <!-- https://www.php.net/manual/es/features.file-upload.errors.php -->

        <!--
UPLOAD_ERR_OK
Valor: 0; No hay error, fichero subido con éxito.

UPLOAD_ERR_INI_SIZE
Valor: 1; El fichero subido excede la directiva upload_max_filesize de php.ini.

UPLOAD_ERR_FORM_SIZE
Valor: 2; El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.

UPLOAD_ERR_PARTIAL
Valor: 3; El fichero fue sólo parcialmente subido.

UPLOAD_ERR_NO_FILE
Valor: 4; No se subió ningún fichero.

UPLOAD_ERR_NO_TMP_DIR
Valor: 6; Falta la carpeta temporal.

UPLOAD_ERR_CANT_WRITE
Valor: 7; No se pudo escribir el fichero en el disco.

UPLOAD_ERR_EXTENSION
Valor: 8; Una extensión de PHP detuvo la subida de ficheros. PHP no proporciona una forma de determinar la extensión que causó la parada de la subida de ficheros; el examen de la lista de extensiones cargadas con phpinfo() puede ayudar.
         -->

<?php
$phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);
?>
 

<?php

        echo 'Más información de depuración:';
        echo "</center><pre>";
        print_r($_FILES);
        echo "</pre><center>";
        echo "<br><br>";



     if($_FILES['video_usuario']){ 
        
        //$dir_subida = '/homepages/44/d885318881/htdocs/playfunnel.net/app/public/subir-ficheros/uploads/';
        $dir_subida = 'uploads/';
        $fichero_subido = $dir_subida . basename($_FILES['video_usuario']['name']);

            //echo ">>".$fichero_subido."<< <br><br>";
            echo "<hr>";
            echo $_FILES['video_usuario']['tmp_name'];
            echo "<br>";
            echo $fichero_subido;
            echo "<hr>" ;


        if (move_uploaded_file($_FILES['video_usuario']['tmp_name'], $fichero_subido)) {
            echo "El fichero es válido y se subió con éxito.\n";
        } 

    }
    if($_FILES['video_usuario']['error']){
        //echo "¡El archivo subido al servidor no se pudo mover a la ubicación destino!\n";
        echo "<b><font color=red>".$phpFileUploadErrors[$_FILES['video_usuario']['error']]."</font></b>";
    }

?>
<iframe id="inlineFrameExample"
    title="Inline Frame Example"
    width="100%"
    height="100%"
    src="http://app.playfunnel.net/dev/subir-ficheros/uploads/">
</iframe>

<?php
//===================================================================================================================
/*
if ($handle = opendir('uploads')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." ) {
            //echo "<b><a href='uploads/".$entry.">".$entry."<b>\n<br>";
            echo "<a href='http://app.playfunnel.net/subir-ficheros/uploads/".$entry."><img src=icono-video.jpg width=50>".$entry."<a>"."<br>\n\n";
            // ----> ".mime_content_type("uploads/".$entry)."<br>";
        }
    }
    closedir($handle);
}
*/


?>

</center>
<style >
    .center {
        margin: auto;
        width: 100%;
        border: 3px solid green;
        padding: 10px;
    }    
</style>


<!-- ---------------------------------------------------------------------------------------------------------->M_1_PI

<script>
$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

jQuery(function ($) {
    "use strict";
    $('#update_profile').validate({
        rules: {
            FirstName: {
                required: true,
                maxlength: 20
            },
            video: {
                required: true,
                extension: "mp4,jpeg",
                filesize: 5,
            }
        },
    });
});
<script>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>


