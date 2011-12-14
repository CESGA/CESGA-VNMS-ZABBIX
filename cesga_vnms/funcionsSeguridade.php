<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once("config.php");



////   ACCESO LDAP conectamos o servidor LDAP do cesga, o cal devolverá true no
//     caso de que o usuarios esté definido, e falso no caso no que non esté


function conexionLDAP($user, $pass) {
    // La secuencia básica para trabajar con LDAP es conectar, autentificarse,
    // buscar, interpretar el resultado de la búsqueda y cerrar la conexión.
    // SALIDAS :
    // 1  -- Usuario válido
    // 0  -- Contraseña incorrecta
    // -1 -- Nombre de Usuario incorrecto
    // -2 -- Acceso no autorizado
    // -3 -- No se ha posido realizar la conexion con el servidor
    // -4 -- El usuario no tiene permisos para acceder a Zabbix

    global $LDAP_BIND_USER;
    global $LDAP_BIN_PASS;
    global $LDAP_SEARCH_DN;
    global $LDAP_SERVER;
    global $LDAP_USE_PERMISSION_ATRIBUTE;
    global $LDAP_PERMISSION_ATRIBUTE;
    
    $ds = ldap_connect($LDAP_SERVER);
    $basedn = $LDAP_SEARCH_DN;
    $retorno = 0;


    if ($ds) {
        $r = ldap_bind($ds, $LDAP_BIND_USER, $LDAP_BIN_PASS);
        if ($r) {
            $sr = ldap_search($ds, $basedn, "(mail=$user)");


            if (ldap_count_entries($ds, $sr) > 0) {

                $info = ldap_get_entries($ds, $sr);

                for ($i = 0; $i < $info["count"]; $i++) {
                    $id = $info[$i]["dn"];
                    if ($LDAP_USE_PERMISSION_ATRIBUTE){
                    $zabbix = $info[$i][$LDAP_PERMISSION_ATRIBUTE];

                    if ($zabbix=="TRUE") {
                        $retorno = -4;
                        break;
                    }
                    }
                    //CESGAvnmp
                    if (ldap_bind($ds, $id, $pass) == TRUE){
                        $retorno = 1;
                        break;
                    }
                }

            } else {
                $retorno =  -1;
            }
        } else {
            $retorno =  -2;
        }
    } else {
        $retorno =  -3;
    }

    ldap_close($ds);

    //echo $retorno;
    RETURN $retorno;

}

function loggin_contra_zabbix($user, $pass){
    global $SERVER_ZABBIX;
    global $DIR_TEMP;
    $directorio = $DIR_TEMP."/login";

                    $comando = 'wget --keep-session-cookies --save-cookies='.$directorio.
                    ' -O /tmp/resultado -q --post-data=\'name='.$user.'&password='.$pass.
                    '&enter=Enter\' '.$SERVER_ZABBIX.'/index.php?login=1';

                    exec($comando);
                    //$codigo = ZabbixAPI::login($SERVER_ZABBIX."/", $user, $pass)
                      //      or die('An error ocurred in your session. Click F5 to refresh ');
                        # Leemos las líneas del fichero
                    $config_lines = file($directorio);
                    $patron = "/[[:alnum:]]{32}$/ ";

                    # Iteramos cada línea
                    foreach ($config_lines as $line) {
                        # Eliminamos comentarios
                        if (( $comment = strpos($line, "#") ) !== false) {
                            $line = substr($line, 0, $comment);
                        }
                        # Parseamos la linea
                        if (preg_match($patron, $line,$resultado)){
                            $resultado = $resultado[0];
                            $resultado = substr($resultado, -16);
                        }
                    }

                    if (empty ($resultado)){
                        $codigo = -2;
                    } else {
                        $codigo = 1;
                    }

                    $comando = 'rm '.$directorio;
                    exec($comando);
           return $codigo;
}


// Encapsulamos nesta función a conexión que vai falla para que a API do zabbix
// nos permita acceso
function loginZabbix() {
    global $SERVER_ZABBIX;
    global $USER_API_ZABBIX;
    global $PASS_API_ZABBIX;

    ZabbixAPI::debugEnabled(TRUE);
    $retorno = ZabbixAPI::login($SERVER_ZABBIX, $USER_API_ZABBIX, $PASS_API_ZABBIX);
    return $retorno;
}


function comproba_session(){

     $cadena = $_SESSION['datoUsuario']['userid']
                        .session_id().$_SESSION['datoUsuario']['alias'];


     $comando= 'find seguridad/ -name '. $cadena;

     $resultado = exec($comando);

     if (strpos($resultado,$cadena)==TRUE){
         return true;
     } else  {
         return false;
     }
    
    
}


// Gardamos as sessions no directorio
function guarda_session(){
    $sessionString = session_encode();
    $nomeFicheroSesion = 'seguridad/'.$_SESSION['datoUsuario']['userid']
                        .session_id().$_SESSION['datoUsuario']['alias'];
    $resultadoA = fopen ($nomeFicheroSesion, 'a');
    fwrite ($resultadoA,$sessionString);
    fclose ($resultadoA);
    return true;
}


function borrado_variables_session_host(){
    unset($_SESSION['mensaje']);
    unset($_SESSION['direccion']);
    unset($_SESSION['graficas']);
    unset($_SESSION['url']);
    unset($_SESSION['hostDatos']);
}

function borrado_variables_session_alarma(){
    unset($_SESSION['lastAlert']);
    unset($_SESSION['alert']);
    unset($_SESSION['url']);
    unset( $_SESSION['gruposItem']);
}

function borrado_variables_session_filtros(){
    unset($_SESSION['FiltradosH']);
    unset($_SESSION['FiltradosG']);
    unset($_SESSION['url']);
}

function borrado_variables_session_busq(){
    unset($_SESSION['ListaCompleta']);
    unset($_SESSION['ListaGrupos']);
    unset($_SESSION['campoBusqHost']);
    unset($_SESSION['campoBusqGrupo']);
}




php?>
