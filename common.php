<?php
/*
 * ============================================================================
 * PROYECTO: n/a
 * ============================================================================
 * AUTOR:         Alfonso Orozco Aguilar (vibecodingmexico.com)
 * PERFIL:        DevOps / Programador desde 1991 / Contaduría
 * FECHA:         05 de Febrero, 2026
 * REQUISITOS:    PHP 5.3 - 8.4+ 
 * LICENCIA:      MIT (Libre uso, mantener crédito del autor)
 * * OBJETIVO: Funciones de control en entornos Legacy
 *
 * NOTA TÉCNICA:
 * Este código es el resultado de años de lidiar con problemas de conversion
 * las funciones están pensados para máxima portabilidad y control de flujo
 * sin sobreingeniería. 5.3 Se usa por compatibilidad  directa con
 * Microsoft SQL_Server
 *
 * Nota: Estas funciones están diseñadas buscando la máxima legibilidad y 
 * compatibilidad entre versiones, evitando sintaxis modernas que rompan 
 * sistemas antiguos.
 */

function domain3(){
// pyede usarse HTTP_HOST segun tu entorno.
// regresa el nombre del dominio actual 
return strtolower($_SERVER['SERVER_NAME']);
} // domain3

function step(){
// parte de mi flujo de trabajo7.x
// requiere php 7.x
return $_GET['step'] ?? "";
}    

function step53(){
// parte de mi flujo de trabajo 5.3
    // Compatible con 5.3 - 8.x
    return isset($_GET['step']) ? $_GET['step'] : "";
}
function universal($string) {
// convertidor que si funciona a utf8
// si tratas de mejorarlo no has tenido el problema que estoy resolviendo
     return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
} // universal


function randomstring($leng= 10){
// no es 100% segura pero cumpleel objetivo, es decir,
// no para passwords pero si para cadenas aleatorias de control
if (intval($leng)==0) $leng=10;
return left(rtrim(base64_encode(md5(microtime())),"="),$leng);
} // tandomstring

function left($str, $length) {
// si bienes de otros lenguajes pero aveces o funciona con bytes segun el encode
     return substr($str, 0, $length);
}
 
function right($str, $length) {
// si bienes de otros lenguajes pero aveces o funciona con bytes segun el encode
     return substr($str, -$length);
}

function MBleft($str, $length) {
// version mas lenta, em multibytes y que aveces hace conversiones internas de UTF8. Imposible saber en unicode largo de lacadena
    return mb_substr($str, 0, $length);
}

function MBright($str, $length) {
// version mas lenta, em multibytes y que aveces hace conversiones internas de UTF8. Imposible saber en unicode largo de lacadena
    return mb_substr($str, -$length);
}

function erroresHTML($number){
// errores al subir archivos                             
// https://www.php.net/manual/en/features.file-upload.errors.php
// se deja asi por legibilidad y soporte 5.3 usado por soporte mssql server
if ($number==0 ) $pass ="File is uploaded successfully | Archivo Cargado exitosamente";
if ($number==1 ) $pass ="Uploaded file cross the limit | Archivo muy grande para el servidor";
if ($number==2 ) $pass ="Uploaded file cross the limit which is mentioned in the HTML form.  | Archivo pasa de el tamaño solicitado ";
if ($number==3 ) $pass ="File is partially uploaded or there is any error in between uploading. | Error de subida parcial, verifique su internet";
if ($number==4 ) $pass ="No file was uploaded. | No se selecciono archivo";
if ($number==6 ) $pass ="Missing a temporary folder. | Falta el folder temporal";
if ($number==7 ) $pass ="Failed to write file to disk. | Error al escribir al disco duro";
if ($number==8 ) $pass ="A PHP extension stopped the uploading process. | Un extensión de PHP ha bloqueado la subida";
return $pass;
} // erroreshtml

function phputf(){
// Busca detectar BOM en archivos php
define ('UTF8_BOM' , chr(0xEF) . chr(0xBB) . chr(0xBF));	
$csh = 0;
$pass =cssalert("yellow","Este proceso revisa que los php sean UTF8, sigue lista de los que NO son utf8, es deseable que no hayan elementos");
$pass .="<table class='table'><tr><th>#</th><th>archivo</th><th>check</th><th>Detect</th><th>bom</th></tr>";
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            
            if (right($entry,4)=='.php') {
              $str=file_get_contents($entry);
              $a =mb_check_encoding($str, 'UTF-8');
              $b=mb_detect_encoding($str, 'UTF-8', true);
  
  $first3 = substr($str, 0, 3); // no uso bin2hex a proposito. Sigue la logica de que hace la funcion antes de corregir.
  $bom="";
  if ($first3 == UTF8_BOM)
	{
		$bom="with BOM";
	}
	else
	{
		$bom="without BOM";
	}
               
               if ($a<>1 or $b<>'UTF-8') {
                  $csh++;
                  $pass .= "<tr><th>$csh<td>$entry</td><td>$a</td><td>$b</td><td>$first3</td></tr>\n ";
               }
   
            }  
        }
    }
    closedir($handle);
    $pass .="</table><hr>";
}
return ($pass);
} // phputf8

function mesdate($mes){
// se deja asi por legibilidad y soporte 5.3 usado por soporte mssql server
$pass="invalido";
$mes=intval($mes);
if ($mes==1) $pass="Enero";
if ($mes==2) $pass="Febrero";
if ($mes==3) $pass="Marzo";
if ($mes==4) $pass="Abril";
if ($mes==5) $pass="Mayo";
if ($mes==6) $pass="Junio";
if ($mes==7) $pass="Julio";
if ($mes==8) $pass="Agosto";
if ($mes==9) $pass="Septiembre";
if ($mes==10) $pass="Octubre";
if ($mes==11) $pass="Noviembre";
if ($mes==12) $pass="Diciembre";
return strtoupper($pass);
} // mesdate
function icono($cual){
// regresa el icono en color negro usado por cssalert
//https://fontawesome.com/v4/icons/
return "<i class='fa fa-$cual' style='color:#000000'></i> | ";
}
function cssalert($color,$mensaje){
// wrapper de mensajes de error de bootstrap
$pass="<div class='alert alert-secondary' role='alert'>\n".icono("info-circle")."$mensaje\n</div>";
if ($color=='green')  { $pass="<div class='alert alert-success' role='alert'>\n".icono("check")."$mensaje\n</div>";}
if ($color=='red')    { $pass="<div class='alert alert-danger'  role='alert'>\n".icono("window-close")."$mensaje\n</div>";}
if ($color=='yellow') { $pass="<div class='alert alert-warning' role='alert'>\n".icono("exclamation-triangle")."$mensaje\n</div>";}
if ($color=='blue')   { $pass="<div class='alert alert-primary' role='alert'>\n".icono("info-circle")."$mensaje\n</div>"; }
return $pass;
} // cssalert
?>
