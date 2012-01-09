<?php
// FUNCIONS WEB
// Neste archivo están las diferentes funciones php que necesita la web
require_once("config.php");


// Función na que entra un código coa prioridade extraída do zabbix e devolve
// nunha cadea de texto os diferentes estados posibles
function prioridad_trigger($codigo){
    if ($codigo == 0){
        // Not Classified
        return '"img/1316604324_Gnome-Dialog-Question-32.png"';
    }
    else if ($codigo == 1){
        //Information
        return '"img/1316604038_Green Ball.png"';
    }
    else if ($codigo == 2){
        //Warning
        return '"img/1316603893_Yellow Ball.png"';
    }
    else if ($codigo == 3){
        //Average
        return '"img/1316604011_Orange Ball.png"';
    }
    else if ($codigo == 4){
        //High       
        return '"img/1316603810_Red_Ball.png"';
    }
    else if ($codigo == 5){
        //Disaster
        return '"img/1316604200_error.png"';
    } 
}

// Función na que entra un código devolto pola base de datos do zabbix que fai
// referencia a se o trigger definido está habilitado ou non
function status_trigger($codigo){
    if ($codigo == 0){
        return "Activo";
    }
    else if ($codigo==1){
        return "Desactivado";
    }
    else if ($codigo==3){
        return "Not Supported";
    }
    else {
        return "Desconocido";
    }
}

// Funcion devolve true se o codigo extraido da base de datos do zabbix é igual a
// 1, e falso no caso de que sexa calquera outro resultado
function esta_alarma_trigger_activada($codigo){
    if($codigo==1){
        return true;
    } else {
        return false;
    }
}


// Funcion para imprimir todos los Triggers definidos en un HOST.
function devolve_todos_triggers($idHost){
        loginZabbix();
        $triggers = ZabbixAPI::fetch_array('trigger', 'getDATA_MVL', array('infoTrigger' => 1,
        'idHost' => $idHost));
}


// Función para a realización de PING
function realizar_ping($hostid) {
    global $DIR_TEMP;

    $directorio = $DIR_TEMP."/cache_MVL_" .$_SESSION['datoUsuario'][userid]. time();
    $directorioPING = $DIR_TEMP."/probaPing" .$_SESSION['datoUsuario'][userid]. time().'.html';
    global $SERVER_ZABBIX;
    global $USER_READ_ONLY_ZABBIX;
    global $PASS_READ_ONLY_ZABBIX;
    $servidor = $SERVER_ZABBIX;
    $user = $USER_READ_ONLY_ZABBIX;
    $pass = $PASS_READ_ONLY_ZABBIX;

    

    $comando = 'wget --keep-session-cookies --save-cookies='.$directorio.
            ' -O /tmp/resultado -q --post-data=\'name='.$user.'&password='.$pass.
            '&enter=Enter\' '.$servidor.'/index.php?login=1';

    exec($comando);
    
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

    echo $resultado.'<br/>';

    $comando= 'wget --load-cookies='.$directorio.' -O '.$directorioPING.
        ' -q \''.$servidor .'/scripts_exec.php?execute=1&hostid'.
        '='.$hostid.'&scriptid=1&sid='.$resultado.'\'';
    exec($comando);
    // parseamos o html
    // Leer el DOM a partir de la URL
    $html = file_get_contents($directorioPING);

    
    $dom_document = new DOMDocument();
    $dom_document->loadHTMLFile($directorioPING);
    $elements = $dom_document->getElementsByTagName('textarea');

    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $node) {
                $resultadoFINAL = $node->nodeValue . "\n";
            }
        }
    }

    //parseamos o resultado para incluirlle saltos de liña
    $resultadoFINAL = str_replace("\n", "<br/><br/>", $resultadoFINAL);

    // e por ultimo eliminamos os ficheiro creados
    $comando = 'rm '.$directorio;
    exec($comando);
    $comando = 'rm '.$directorioPING;
    exec($comando);
    $comando = 'rm '.$DIR_TEMP.'/resultado';
    exec($comando);

    return $resultadoFINAL;
}


// Función para a realización de TRACEROUTE
function realizar_trace($hostid) {
    global $DIR_TEMP;
    $directorio = $DIR_TEMP."/cache_MVL_" .$_SESSION['datoUsuario'][userid]. time();
    $directorioTrace = $DIR_TEMP."/probaTrace" .$_SESSION['datoUsuario'][userid]. time().'.html';
    global $SERVER_ZABBIX;
    global $USER_READ_ONLY_ZABBIX;
    global $PASS_READ_ONLY_ZABBIX;
    $servidor = $SERVER_ZABBIX;
    $user = $USER_READ_ONLY_ZABBIX;
    $pass = $PASS_READ_ONLY_ZABBIX;



    $comando = 'wget --keep-session-cookies --save-cookies='.$directorio.
            ' -O /tmp/resultado -q --post-data=\'name='.$user.'&password='.$pass.
            '&enter=Enter\' '.$servidor.'/index.php?login=1';

    exec($comando);

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

    //echo $resultado.'<br/>';

    $comando= 'wget --load-cookies='.$directorio.' -O '.$directorioTrace.
        ' -q \''.$SERVER_ZABBIX.'/scripts_exec.php?execute=1&hostid'.
        '='.$hostid.'&scriptid=2&sid='.$resultado.'\'';
    exec($comando);
    //echo $comando;
    // parseamos o html
    // Leer el DOM a partir de la URL
    $html = file_get_contents($directorioTrace);

    $dom_document = new DOMDocument();
    $dom_document->loadHTMLFile($directorioTrace);
    $elements = $dom_document->getElementsByTagName('textarea');

    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $node) {
                $resultadoFINAL = $node->nodeValue . "\n";
            }
        }
    }

    //parseamos o resultado para incluirlle saltos de liña
    $resultadoFINAL = str_replace("\n", "<br/><br/>  ", $resultadoFINAL);

    // e por ultimo eliminamos os ficheiro creados
    $comando = 'rm '.$directorio;
    exec($comando);
    $comando = 'rm '.$directorioTrace;
    exec($comando);
    $comando = 'rm '.$DIR_TEMP.'/resultado';
    exec($comando);


    return $resultadoFINAL;
}


function devolve_grafica($idgraf, $directorioGraf,$width,$height, $period){
    global $DIR_TEMP;
    $directorio = $DIR_TEMP."/cache_MVL_" .$_SESSION['datoUsuario'][userid]. time();
    global $SERVER_ZABBIX;
    global $USER_READ_ONLY_ZABBIX;
    global $PASS_READ_ONLY_ZABBIX;
    $servidor = $SERVER_ZABBIX;
    $user = $USER_READ_ONLY_ZABBIX;
    $pass = $PASS_READ_ONLY_ZABBIX;



    $comando = 'wget --keep-session-cookies --save-cookies='.$directorio.
            ' -O /tmp/resultado -q --post-data=\'name='.$user.'&password='.$pass.
            '&enter=Enter\' '.$servidor.'/index.php?login=1';

    exec($comando);

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

    $comando        = "wget --load-cookies=".$directorio." -O ".$directorioGraf." -q ".
                      "\"$SERVER_ZABBIX/chart2.php?graphid=".$idgraf.
                      "&width=".$width."&height=".$height."&period=". $period ."\"";
    exec($comando);

    
    // e por ultimo eliminamos os ficheiro creados
    $comando = 'rm '.$directorio;
    exec($comando);
    $comando = 'rm '.$DIR_TEMP.'/resultado';
    exec($comando);
    
    return $directorioGraf;
}


// Función para a realización de TRACEROUTE
function devolve_datos_textuais($itemid) {
    global $DIR_TEMP;
    $directorio = $DIR_TEMP."/cache_MVL_" .$_SESSION['datoUsuario'][userid]. time();
    $directorioTrace = $DIR_TEMP."/datos_text" .$_SESSION['datoUsuario'][userid]. time().'.html';
    global $SERVER_ZABBIX;
    global $USER_READ_ONLY_ZABBIX;
    global $PASS_READ_ONLY_ZABBIX;
    $servidor = $SERVER_ZABBIX;
    $user = $USER_READ_ONLY_ZABBIX;
    $pass = $PASS_READ_ONLY_ZABBIX;



    $comando = 'wget --keep-session-cookies --save-cookies='.$directorio.
            ' -O /tmp/resultado -q --post-data=\'name='.$user.'&password='.$pass.
            '&enter=Enter\' '.$servidor.'/index.php?login=1';

    exec($comando);

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

    //echo $resultado.'<br/>';

    $comando= 'wget --load-cookies='.$directorio.' -O '.$directorioTrace.
        ' -q \''.$SERVER_ZABBIX.'/history.php?&sid='.$resultado.'&itemid'.
        '='.$itemid.'&action=showvalues&period=1296000\'';
    exec($comando);
    // parseamos o html
    // Leer el DOM a partir de la URL
    $html = file_get_contents($directorioTrace);

    $dom_document = new DOMDocument();
    $dom_document->loadHTMLFile($directorioTrace);
    $elements = $dom_document->getElementsByTagName('div');


    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $node) {
                $resultadoFINAL = $node->nodeValue . "\n";
            }
        }
    }


    //parseamos o resultado para incluirlle saltos de liña
    $resultadoFINAL = str_replace("\n", "<br/>", $resultadoFINAL);
    $resultadoFINAL = str_replace("<br/><br/><br/>", "<br/>", $resultadoFINAL);
    $resultadoFINAL = str_replace("<br/><br/>", "<br/>", $resultadoFINAL);
    $tokens=split("<br/>",$resultadoFINAL);

    $resultadoFINAL = array_slice($tokens, 3);
    $resultadoFINAL = array_chunk($resultadoFINAL, 2);
    //// devuelve "d"
    // e por ultimo eliminamos os ficheiro creados


    $comando = 'rm '.$directorio;
    exec($comando);
    $comando = 'rm '.$directorioTrace;
    exec($comando);
    $comando = 'rm '.$DIR_TEMP.'/resultado';
    exec($comando);
 
     


    return $resultadoFINAL;
}





function configuracionHost($user,$iduser){

    $conf = "conf/".$user.$iduser."HOST.conf";

    if (!file_exists($conf)){
       $fp = fopen($conf, "w+");
       fclose($fp);
    }

    return $conf;

}

function configuracionGrupo($user,$iduser){

    $conf = "conf/".$user.$iduser."GRUPOS.conf";

    if (!file_exists($conf)){
       $fp = fopen($conf, "w+");
       fclose($fp);
    }

    return $conf;

}

function filtra($fichero,$id) {

    $contenido = file_get_contents($fichero);

    $existe = false;
    if (empty($contenido)==false){
        $contenido = str_replace("\n", " ", $contenido);
        $tokens=split(" ",$contenido);

        foreach ($tokens as $token) {
            if (strcmp($id,$token)==0) {
                $existe = true;
                break;
            }
        }
    }

    if ($existe==false){
        $fp = fopen($fichero, "ab");
        fwrite($fp, " ".$id);
        fclose($fp);
    }
}

function desfiltra($fichero,$id) {

    $contenido = file_get_contents($fichero);

    //echo 'entra';
    $resultado="";
    if (empty($contenido)==false){
        $contenido = str_replace("\n", " ", $contenido);
        $tokens=split(" ",$contenido);

        foreach ($tokens as $token) {
            if (strcmp($id,$token)!=0) {
                $resultado =$resultado." ".$token;
            } 
        }
    }
    //echo 'sale';
    //print_r($resultado);
    $resultado = str_replace(" ", "\n", $resultado);



    //print_r($resultado);
    if ((empty($resultado))==FALSE){
        $fp = fopen($fichero, "wb");
        fwrite($fp, " ".$resultado);
        fclose($fp);
    }

}


function extraeArrayID($fichero){
    $contenido = file_get_contents($fichero);
    $resultado = array();
    $contenido = str_replace("\n", " ", $contenido);
    $tokens=split(" ",$contenido);
    $i=0;
        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $resultado[]=$token;
            }
            $i=$i+1;
        }
        return $resultado;

}

function super_unique($array)
{
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach ($result as $key => $value)
  {
    if ( is_array($value) )
    {
      $result[$key] = super_unique($value);
    }
  }

    //reorder
    foreach ($result as $key => $row) {
        $host[$key] = $row['host'];
    }
    // Sort the data with host name ascending,
    array_multisort($host, SORT_ASC, $result);

  return $result;
}


function filtraResultadosHost($resultados,$filtrados){




    if (empty ($filtrados)== FALSE){
        $res = array();
        $cont = 0;
        for ($i=0;$i<count($resultados);$i++){
            if (in_array($resultados[$i]['hostid'], $filtrados)==FALSE){
                $res[$cont]['hostid'] = $resultados[$i]['hostid'];
                $res[$cont]['host'] = $resultados[$i]['host'];
                $res[$cont]['ip'] = $resultados[$i]['ip'];
                $res[$cont]['name'] = $resultados[$i]['name'];
                $cont++;
            }
        }
        return super_unique($res);
    } else {
        return super_unique($resultados);
    }
return super_unique($resultados);

}


function filtraResultadosGrupos($resultados,$filtrados){

    if (empty ($filtrados)== FALSE){
        $res = array();
        $cont = 0;
        for ($i=0;$i<count($resultados);$i++){
            if (in_array($resultados[$i]['groupid'], $filtrados)==FALSE){
                $res[$cont] = $resultados[$i];
                $cont++;
            }
        }
        return $res;
    } else {
        return $resultados;
    }

}

function filtraTriggersGrupos($resultados,$filtrados){

    if (empty ($filtrados)== FALSE){
        $res = array();
        $cont = 0;
        for ($i=0;$i<count($resultados);$i++){
            $quita = true;
            print_r($resultados);
            echo '<br/><br/>'; 
            foreach ($resultados[groups] as $g){
                echo $g;
                echo '<br/><br/>';
                if (in_array($g['groupid'], $filtrados)==FALSE){
                    $quita = false;
                }
             }

             if ($quita == true){
                    $res[$cont] = $resultados[$i];
                    $cont++;
             }
        }
        return $res;
    } else {
        return $resultados;
    }

}


function contaFiltrados($fichero){
    $contenido = file_get_contents($fichero);
    $resultado = array();
    $contenido = str_replace("\n", " ", $contenido);
    $tokens=split(" ",$contenido);
    $i=0;
        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $resultado[]=$token;
            }
            $i=$i+1;
        }
        return count($resultado);
}


function metendoEspacios(){
     //if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 5_0') !== false) { };
    if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone OS 5_0')){
        //echo '<br/><br/>';
    }



}






php?>