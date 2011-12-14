

<?php

session_start();
require_once("ZabbixAPI.class.php");
require_once("funcions.php");
require_once("funcionsWEB.php");
require_once("funcionsSeguridade.php");
require_once("config.php");

global $user;
$user = $_POST['nombreUsuario'];
global $pass;
$pass = $_POST['passUsuario'];
global $nuevaBusq;
$nuevaBusq = $_GET['nuevaBusq'];
global $alert;
$alert = $_GET['alerta'];
global $ack;
$ack =$_GET['ack'];
global $eventid;
$eventid =$_GET['eventid'];
global $comandoPING;
$comandoPING = $_GET['executaPing'];
global $comandoTRACE;
$comandoTRACE = $_GET['executaTrace'];
global $grafica;
$grafica = $_GET['grafica'];
global $logout;
$logout = $_GET['logout'];
global $tools;
$tools = $_GET['tools'];
global $configuracion;
$configuracion=$_GET['configuracion'];
global $filtrarG;
$filtrarG=$_POST['filtraG'];
global $filtrarH;
$filtrarH=$_POST['filtraH'];
global $gfilter;
$gfilter = $_POST['groupHostFilt'];
global $ggfilter;
$ggfilter = $_POST['groupFilt'];
global $sms;
$sms = $_GET['sms'];
global $hostSMS;
$hostSMS = $_GET['host'];
global $hostAck;
$hostAck = $_GET['hostAck'];
global $enableSMS;
$enableSMS = $_GET['enable'];
global $screens;
$screens = $_GET['screens'];
global $screenid;
$screenid = $_GET['getscreens'];
$identificado = 0;


/* SEND ACK */
/* This function send one ack for particulary host */
function send_ack()
{
    $ret = loginZabbix();
    if ($ret!=""){
    global $eventid;
    global $hostAck;

    $userDato = ZabbixAPI::fetch_array('user', 'get',
                            array(
                            'extendoutput' => 1,
                            'userids' => array($_SESSION['datoUsuario']['userid'])));
   
    if ($userDato[0][type] == 3 ) {

    $re = ZabbixAPI::fetch_array('trigger', 'getDATA_MVL', array('userid' => $_SESSION['datoUsuario']['userid'],
        'eventid' => $eventid, 'ack' => 1, 'time' => time()));

    $hostidd=ZabbixAPI::fetch_array('host','getDATA_MVL',
                array('returnHostid' => $hostAck ));

    $id = $hostidd['hostid']['hostid'];
    $group=ZabbixAPI::fetch_array('host','get',array(hostids => array ($id), select_groups => "extend"));
    $div = 'alertas'.$group[0][groups][0][name];

    }
    
    header("Location: controlador.php?alerta=1&div=".$div);

    } else  {
        require_once("errorLog.php");
    }
}


/* GET HOST LIST */
/* This function return a list host */
function get_host_list()
{
        //borrado_variables_session_host();
        //borrado_variables_session_alarma();
        //borrado_variables_session_filtros();
     $ret = loginZabbix();
     if ($ret!=""){

        $lhost = extraeArrayID($_SESSION['configuracionH']);
        $lgrupos = extraeArrayID($_SESSION['configuracionG']);


    // Si es una nueva busqueda borramos de sesion el numero de resultados de la Busqueda
    //if (!is_null($nuevaBusq)){
        $fijoH = 0;
        $fijoG = 0;
        
        if (empty($_GET['campoBusqHost'])){
            $_SESSION['campoBusqHost'] = $_GET['campoBusqHost2'];
            if ($_SESSION['campoBusqHost'] != ""){
                $fijoH =1;
            }
        } else {
            $_SESSION['campoBusqHost'] = $_GET['campoBusqHost'];
        }


        
        
        if (empty($_GET['campoBusqGrupo'])){
            $_SESSION['campoBusqGrupo'] = $_GET['campoBusqGrupo2'];

            if ($_GET["select"] == 1){
                $fijoH = 2;
                $fijoG = 1;
            }
            else {
            
                if ($_SESSION['campoBusqGrupo'] != "" && $fijoH==0){
                    $fijoG =1;
                }
                else if ($_SESSION['campoBusqGrupo'] != "" && $fijoH==1){
                    $fijoG =1;

                    $fijoH = 0;
                }
            }
        } else {
            $_SESSION['campoBusqGrupo'] = $_GET['campoBusqGrupo'];
        }


       if (($fijoH==0)&&($fijoG==0)){
            $_SESSION['ListaCompleta']=
            filtraResultadosHost(
            filtraResultadosGrupos(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>$_SESSION['campoBusqHost'],
                    'busqGROUP' => $_SESSION['campoBusqGrupo']))
                    ,$lgrupos)
            , $lhost);
        }
        else if (($fijoH==1)&&($fijoG==0)){
            $_SESSION['ListaCompleta']=
            filtraResultadosHost(
            filtraResultadosGrupos(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>$_SESSION['campoBusqHost'],
                    'busqGROUP' => $_SESSION['campoBusqGrupo'],
                    'fijoH' => 1
                    ))
                    ,$lgrupos)
            , $lhost);
        }
        else if (($fijoH==0)&&($fijoG==1)){
            $_SESSION['ListaCompleta']=
            filtraResultadosHost(
            filtraResultadosGrupos(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>$_SESSION['campoBusqHost'],
                    'busqGROUP' => $_SESSION['campoBusqGrupo'],
                    'fijoG' => 1
                    ))
                    ,$lgrupos)
            , $lhost);
            
        }
        else if (($fijoH==1)&&($fijoG==1)){
            $_SESSION['ListaCompleta']=
            filtraResultadosHost(
            filtraResultadosGrupos(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>$_SESSION['campoBusqHost'],
                    'busqGROUP' => $_SESSION['campoBusqGrupo'],
                    'fijoG' => 1,
                    'fijoH' => 1
                    ))
                    ,$lgrupos)
            , $lhost);
        }
        else if (($fijoH==2)&&($fijoG==1)){
            $_SESSION['ListaCompleta']=
            filtraResultadosHost(
            filtraResultadosGrupos(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>"",
                    'busqGROUP' => $_SESSION['campoBusqGrupo'],
                    'fijoG' => 1
                    ))
                    ,$lgrupos)
            , $lhost);
        }

        // Filtra resultados
        $_SESSION['nResultados'] = count($_SESSION['ListaCompleta']);
        $_GET["numero"] = 0;


        if ($_SESSION['ListaCompleta'][0][hostid]==""){
            $nResultados=ZabbixAPI::fetch_array('host','getDATA_MVL',
                array(
                    'cuentaResultados' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>"",
                    'busqGROUP' => ""
                    ));
            $_SESSION['nResultados'] =
                $nResultados[0]['COUNT(h.hostid)']-contaFiltrados($_SESSION['configuracionH']);
            $_SESSION['ListaCompleta']=
            filtraResultadosGrupos(
            filtraResultadosHost(ZabbixAPI::fetch_array(
                'host','getDATA_MVL',
                array(
                    'listaHost' => 1,
                    'userid' => $_SESSION['datoUsuario']['userid'],
                    'busqHOST' =>"",
                    'sortfield' => "name",
                    'busqGROUP' => "")),$lhost)
            , $lgrupos);
            $_SESSION['campoBusqGrupo'] = "";
            $_SESSION['campoBusqHost'] = "";
            $_SESSION[vacio] = 1;

        } else {
            $_SESSION[vacio] = null;
        }

        $_SESSION['ListaGrupos'] = filtraResultadosGrupos(
                ZabbixAPI::fetch_array('hostgroup','get',array(
        output => 'extend',
                    'sortfield' => "name",
        'userid' => $_SESSION['datoUsuario']['userid'])),$lgrupos);


    if (!is_null($_GET['sub'])&&($_GET['sub']==1)){
        header('Location: lista_host.php#allhost0');
    }
    else if (!is_null($_GET['sub'])&&($_GET['sub']==0)){
        header('Location: lista_host.php#search');
    }
    else{
        header('Location: lista_host.php');
    }
     } else {


        require_once("errorLog.php");

         
     }
}


/* GET HOST INF */
/* This function return all information about one host */
function get_host_inf()
{
    //borrado_variables_session_alarma();
    //borrado_variables_session_filtros();
    // alertaHost
    $ret = loginZabbix();
    if ($ret!=""){
    $infoTRAP = ZabbixAPI::fetch_array('host','get',
                    array(
                        hostids => array($_GET['idhost']),
                        select_items => 'extend',
                        output => 'refer'
                    )
                    );



    $inform_T = array();
    $cont = 0;
    foreach ($infoTRAP[0][items] as $it){
        if ($it[type]==2){
            $inform_T[$cont][id] = $it[itemid];
            $inform_T[$cont][des] = $it[description];
            $inform_T[$cont][datos] = devolve_datos_textuais($it[itemid]);
            $cont++;
        }
    }



    $_SESSION[TRAPS] = $inform_T;

    $triggers=ZabbixAPI::fetch_array('trigger',
            'get',array(
                active => 0,
                monitored => 1,
                templated => 0,
                maintenance=>0,
                skipDependent => 1,
                only_problems => 1,
                hostids => array($_GET['idhost']),
                output => 'extend',
                select_hosts =>  'refer',
                select_groups => 'refer',
                expandData => "true", 
                sortfield => "lastchange" ,
                sortorder => "DESC",
                userid=>$_SESSION['datoUsuario']['userid']));

    $info_alert = array();
    $cont = 0;
    
    foreach ($triggers as $tr){
<<<<<<< HEAD
        if ($tr[value]>0) {
=======
>>>>>>> 71fd72616a5f2fc3da0a5f2b0ff1b2a85c6c22c5
        $info_alert[$cont][priority]=$tr[priority];
        $info_alert[$cont][status]=$tr[status];
        $info_alert[$cont][value]=$tr[value];
        $info_alert[$cont][description]=$tr[description];
        $info_alert[$cont][triggerid]=$tr[triggerid];
        $info_alert[$cont][timeEvento]=$tr[lastchange];
        $t=ZabbixAPI::fetch_array('event','event_MVL',
                array(triggerid => $tr[triggerid],
                clock => $tr[lastchange]));
        $info_alert[$cont][clock] = $tr[lastchange];
        $info_alert[$cont][eventid]=$t[0][eventid];
        $info_alert[$cont][valorEvento]=$t[0][value];
        $info_alert[$cont][acknowledged]=$t[0][acknowledged];
        $cont++;
<<<<<<< HEAD
        }
=======
>>>>>>> 71fd72616a5f2fc3da0a5f2b0ff1b2a85c6c22c5
    }

    
    $_SESSION['hostDatos'] = $info_alert;

    $_SESSION['graficas'] = ZabbixAPI::fetch_array('host', 'getDATA_MVL',
            array('retornaGraficas' => 1, 'hostid' => $_GET['idhost']));

    $sms = ZabbixAPI::fetch_array('action','action_MVL',
                                        array('status' => 1, 'hostid' => $_GET['idhost'] ));



    $_SESSION['profile'] = ZabbixAPI::fetch_array('host', 'getDATA_MVL',
            array('getprofile' => 1, 'hostid' => $_GET['idhost'])); 

    // SI ACCEDEMOS DESDE LA LISTA DE HOST
    if (is_null($_GET['alertaHost'])){
        $_SESSION['estaEnAlerta']=0;
        header("Location: host.php?host=".$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
           .'&sms='.$sms['status'].'&hostid='.$_GET['idhost'].'#home');
    }
    // SI ACCEDEMOS DESDE LA LISTA DE EL MENU DE ALERTAS
    else {
        $_SESSION['estaEnAlerta']=1;
        header("Location: host.php?host=".$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
           .'&sms='.$sms['status'].'&hostid='.$_GET['idhost'].'#home');
    }
    } else {

        require_once("errorLog.php");
        
    }
}


/* MAKE PING */
/* This function executes ping command in server to selected host */
function make_PING()
{
    $mensaje = realizar_ping($_GET['hostid']);

     $_SESSION['mensaje'] = $mensaje;
       header('Location: resultado.php?hostid='.$_GET['hostid'].'&host='.$_GET['host'].
            '&ip='.$_GET['ip'].'&grupo='.$_GET['grupo'].
            '&ping=1');
}


/* MAKE TRACEROUTE */
/* This function executes traceroute command in server to selected host */
function make_TRACEROUTE()
{
    $mensaje = realizar_trace($_GET['hostid']);

    $_SESSION['mensaje'] = $mensaje;
    header('Location: resultado.php?hostid='.$_GET['hostid'].'&host='.$_GET['host'].
            '&ip='.$_GET['ip'].'&grupo='.$_GET['grupo'].
            '&trace=1');
}


/* GET GRAPHS */
/* This function saves in session, graphic directories  */
function get_GRAPHS()
{

$_SESSION["listaRutas"]=null;
    // pode estar vacia a lista

    $lista_idg = $_POST["grafics"];



    // lista de rutas
    $route_list = array();
    $name_list = array();
    if (count($lista_idg)>0){
        for ($i=0;$i<count($lista_idg);$i++){
            $p = stripos($lista_idg[$i], '_');
            $idgraf = substr($lista_idg[$i], 0, $p);
            $namegraf = substr($lista_idg[$i], -(strlen($lista_idg[$i]) - 1  - $p), strlen($lista_idg[$i])-1) ;

            $directorioGraf = "graficas/grafica" .$idgraf. time().'.png';
            if((strstr($_SERVER['HTTP_USER_AGENT'],'Mobile')==false)||
                    strstr($_SERVER['HTTP_USER_AGENT'],'iPad')==true){
                $directorioGraf =
                devolve_grafica($idgraf,$directorioGraf,500,400,3600);
            } else {
                $directorioGraf =
                devolve_grafica($idgraf,$directorioGraf,220,150,3600);
            }
            $route_list[$idgraf] = $directorioGraf;
            $name_list[$i] = $namegraf;
        }

        $_SESSION["listaRutas"]=$route_list;
        $_SESSION["NameG"]=$name_list;



        header('Location: grafica.php?hostid='.$_GET['hostid'].'&host='.$_GET['host'].
           '&ip='.$_GET['ip'].'&grupo='.$_GET['grupo']);
    } else {
        header('Location: grafica.php?hostid='.$_GET['hostid'].'&host='.$_GET['host'].
           '&ip='.$_GET['ip'].'&grupo='.$_GET['grupo'].'&vacio=1');
    }
}


/* RETURN DYNAMIC GRAPH */
/*  This function  returns  dynamically directories of graphics  */
function return_dynamic_graph()
{
    // pode estar vacia a lista
    $id_dinamic = $_GET["g_Dinamica"];
    $anch_dinamic = $_GET["anch_Dinamica"];
    $alto_dinamic = $_GET["alt_Dinamica"];
    $periodo_dinamic = $_GET["per_Dinamica"];

    $directorioGraf = "graficas/grafica" .$id_dinamic. time().'.png';
    $directorioGraf = devolve_grafica($id_dinamic,$directorioGraf,
            $alto_dinamic,$anch_dinamic,$periodo_dinamic);

    $_SESSION["listaRutas"][$id_dinamic] = $directorioGraf;

    echo $directorioGraf;
}


/* GO TOOLS */
/* This function redirects to tools page. */
function go_tools()
{
     header("Location: tools.php");
}


/* LOGOUT */
/* This function check */
function logout()
{
    //crear y destruir session


    $comando= 'rm -f seguridad/'.$_SESSION['datoUsuario']['userid']
                        .session_id().$_SESSION['datoUsuario']['alias'];
    echo $comando;

    $resultado = exec($comando);
    // vaciarla
    $_SESSION = array();
    // destruirla
    session_destroy();
    ////////////////////////
    header("Location: index.php");
}


/* SETTINGS */
/* This function is for config */
function settings()
{
    //borrado_variables_session_host();
    //borrado_variables_session_alarma();
    //borrado_variables_session_busq();
    $ret = loginZabbix();
    if ($ret!=""){
    $lgrupos = extraeArrayID($_SESSION['configuracionG']);
    $lhost = extraeArrayID($_SESSION['configuracionH']);



    $listaG=filtraResultadosGrupos(
        ZabbixAPI::fetch_array('hostgroup','get',array(
        output => 'extend',
        select_hosts => 'extend',
        'sortfield' => "name",
        'userid' => $_SESSION['datoUsuario']['userid']))
                ,$lgrupos);


    //if (!empty($_SESSION['ListaCompleta'])){
        //$_SESSION['ListaCompleta']=$listaH;
    //}
    //if (!empty($_SESSION['ListaGrupos'])){
        $_SESSION['ListaGrupos'] =$listaG;
        $_SESSION['ListaGruposH']=ZabbixAPI::fetch_array('hostgroup','get',array(
        output => 'extend',
        select_hosts => 'extend',
        'sortfield' => "name",
        'userid' => $_SESSION['datoUsuario']['userid']));
    //}


    $_SESSION['FiltradosH']=$lhost;
    $_SESSION['FiltradosG']=$lgrupos;

    header("Location: configuracion.php");
    } else {

        require_once("errorLog.php");

        
    }
}


/* SET SMS HOST */
/* This function anble/disable sms host option */
function set_sms_host() {
    $ret = loginZabbix();
    if ($ret != "") {

        $userDato = ZabbixAPI::fetch_array('user', 'get',
                        array(
                            'extendoutput' => 1,
                            'userids' => array($_SESSION['datoUsuario']['userid'])));

        if ($userDato[0][type] == 3) {
            global $hostSMS;
            global $enableSMS;
            // hostname
            $hostidd = ZabbixAPI::fetch_array('host', 'getDATA_MVL',
                            array('returnHostid' => $hostSMS));

            $id = $hostidd['hostid']['hostid'];
            $group = ZabbixAPI::fetch_array('host', 'get', array(hostids => array($id), select_groups => "extend"));
            $div = 'alertas' . $group[0][groups][0][name];

            if ($enableSMS == 1)
                $activa = "true";
            else
                $activa = "false";

            ZabbixAPI::fetch_array('action', 'action_MVL',
                            array('enable' => $activa, 'hostid' => $id));
        }

        if (!is_null($_GET['desdeAlarma'])) {
            header("Location: controlador.php?alerta=1&div=" . $div);
        } else {
            $info = ZabbixAPI::fetch_array('host', 'get', array(hostids => array($id), output => "extend"));

            header("Location: controlador.php?idhost=" . $info[0][hostid] . '&host=' . $hostSMS
                    . "&ip=" . $info[0][ip] . "&grupo=" . $group[0][groups][0][name]);
        }
    } else {
        require_once("errorLog.php");
    }
}


/* FILTER DEFILTER */
/* This function filter or defilter hosts and groups */
function filter_defilter()
{

    $ret = loginZabbix();
    if ($ret!=""){
    global $filtrarG;
    global $filtrarH;
    global $ggfilter;
    global $gfilter;

    if (!is_null($ggfilter)) {

            $dfiltrarG = array();
            if (!is_null($filtrarG)){
                $d = array_diff($_SESSION['FiltradosG'],$filtrarG);
            } else {
                $d = $_SESSION['FiltradosG'];
            }

            while ($elem = current($d)) {
                $dfiltrarG[] = $elem;
                next($d);
            }


            for ($i = 0; $i < count($filtrarG); $i++) {
                filtra($_SESSION['configuracionG'], $filtrarG[$i]);
            }


            for ($i = 0; $i < count($dfiltrarG); $i++) {
                desfiltra($_SESSION['configuracionG'], $dfiltrarG[$i]);
            }

            header("Location:  controlador.php?configuracion=1#filterG");
     }


     else if (!is_null($gfilter)){

        $idsH = ZabbixAPI::fetch_array('host', 'get', array('groupids' => $gfilter));
        $idsgrupo = array();
        foreach ($idsH as $h){
            $idsgrupo[] = $h[hostid];
        }


        $dfiltrarH = array();
        if (!is_null($filtrarH)){
            $p = array_diff($idsgrupo,$filtrarH);
        } else {
            $p = $idsgrupo;
        }

        while ($elem = current($p)) {
            $dfiltrarH[] = $elem;
            next($p);
        }

        for ($i=0;$i<count($filtrarH);$i++){
            filtra($_SESSION['configuracionH'], $filtrarH[$i]);
        }

        for ($i=0;$i<count($dfiltrarH);$i++){
            desfiltra($_SESSION['configuracionH'], $dfiltrarH[$i]);
        }

        header("Location: controlador.php?configuracion=1#filterH");
    }
    } else {

        require_once("errorLog.php");

    }
}


/* GO TO DASHBOARD */
/* This function redirects to dashboard page. */
function go_to_dashboard()
{
    ////borrado_variables_session_host();
    ////borrado_variables_session_filtros();
    ////borrado_variables_session_busq();
    $lgrupos = extraeArrayID($_SESSION['configuracionG']);

    global $sms;
    //if ($identificado == 0){
    $ret = loginZabbix();
    if ($ret!=""){
    //}

    $gruposTotais =

        ZabbixAPI::fetch_array('hostgroup','get',array(
        output => 'extend',
       'sortfield' => "name",
        'userid' => $_SESSION['datoUsuario']['userid']));
    $gruposNOfiltrados = array();
    foreach ($gruposTotais as $gr){
        if (!in_array($gr[groupid],$lgrupos)){
            $gruposNOfiltrados[] = $gr[groupid];
        }
    }

    
    $lhost = extraeArrayID($_SESSION['configuracionH']);


    $alert1=
    ZabbixAPI::fetch_array('trigger',
            'get',array(
                active => 0,
                monitored => 1,
                templated => 0,
                maintenance=>0,
                skipDependent => 1,
                only_problems => 1,
                output => 'extend',
                select_hosts =>  'refer',
                select_groups => 'refer',
               'sortfield' => "name",
                groupids => $gruposNOfiltrados,
                expandData => "true", sortfield => "lastchange" ,
                sortorder => "DESC",
                userid=>$_SESSION['datoUsuario']['userid']));


    
    $alertas = array();
    $cont = 0;
    foreach ($alert1 as $p){
<<<<<<< HEAD
        if (!in_array($p[hosts][0][hostid],$lhost)
              && ($p[value]>0)){
=======
        if (!in_array($p[hosts][0][hostid],$lhost)){
>>>>>>> 71fd72616a5f2fc3da0a5f2b0ff1b2a85c6c22c5
            $group= ZabbixAPI::fetch_array('host','get',
                array(hostids => array ($p[hosts][0][hostid]),
                select_groups => "extend",
                'sortfield' => "name",
                output => "extend",
                userid=>$_SESSION['datoUsuario']['userid']));

            $alertas[$cont][hostid] = $p[hosts][0][hostid];
            $alertas[$cont][host] = $group[0][host];
            $alertas[$cont][ip] = $group[0][ip];
            $alertas[$cont][name] = $group[0][groups][0][name];

            $alertas[$cont][description] = $p[description];
            $alertas[$cont][triggerid] = $p[triggerid];
            $alertas[$cont][priority] = $p[priority];
            $alertas[$cont][clock] = $p[lastchange];
            $t=ZabbixAPI::fetch_array('event','event_MVL',
                array(triggerid => $p[triggerid],
                clock => $p[lastchange]));
            $alertas[$cont][eventid] = $t[0][eventid];
            $alertas[$cont][acknowledged] = $t[0][acknowledged];
            $cont++;
        }
    }


    $cont1=0;
    $gruposItems = array();

    $grupo =$alertas[0]['name'];
    if ($grupo!=null){
                $gruposItems[0]['grupo'] = $alertas[0]['name'];
                $gruposItems[0]['num'] = 0;
    }
    $cont = 0;

    $grup = array();
    for ($i=0;$i<count($alertas);$i++){
        if (!in_array($alertas[$i]['hostid'], $lhost)){
            $sms = ZabbixAPI::fetch_array('action','action_MVL',
                                        array('status' => 1, 'hostid' => $alertas[$i][hostid] ));
            $alertas[$i]['sms'] =  $sms['status'];
            $resultadoH[$cont1] = $alertas[$i];
            $cont1++;
            if (in_array($alertas[$i]['name'],$grup)){
                $pos = array_search($alertas[$i]['name'],$grup);
                $gruposItems[$pos]['num']++;
            }
            else{
                $grup[] = $alertas[$i]['name'];
                $gruposItems[$cont]['grupo'] = $alertas[$i]['name'];
                $gruposItems[$cont]['num'] = 1;
                $grupo = $alertas[$i]['name'];
                $cont++;
            }
        }
    }

    $_SESSION['gruposItem'] = $gruposItems;
    $_SESSION['alert'] = $resultadoH;



    // CALC LAST 20 ISSUES
    $ultimasAlarmas = array();
    $alarmasDate = array();
    $count = 0;

    while ($count < $alertas[$count]) {
        $alarmasDate[$count] = $alertas[$count];
        if ($count <20) {
            $ultimasAlarmas[$count] = $alertas[$count];
        }
        $count = $count +1;
    }



    $_SESSION['lastAlert'] = $ultimasAlarmas;
    $_SESSION['dataAlert'] = $alarmasDate;


    if ($div!=""){
        header("Location: principal.php?refresca=1".$div);
    } else {
        header("Location: principal.php?refresca=1");
    }
    } else {
        require_once("errorLog.php");
    }
}


/* LOGIN */
function login()
{
    global $user;
    global $pass;
    global $identificado;
    global $LOGIN_WITH_LDAP;
    global $SERVER_ZABBIX;
    global $USER_API_ZABBIX;
    global $PASS_API_ZABBIX;

    
    if (!is_null($user) && !is_null($pass)) {
        $expEmail = "^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$";

        // Controlar el contenido del campo usuario y del password antes de acceder
        // al LDAP
        if (eregi($expEmail, $user)) {
            if (!($pass == "")) {

                if ($LOGIN_WITH_LDAP){
                    // Conectamos al LDAP
                    $codigo = conexionLDAP($user, $pass);
                } else {
                    $codigo = loggin_contra_zabbix($user,$pass);
                }

                if ($codigo == 1) {
                    // identificamonos para acceder os datos do zabbix
                    $loginValido =  loginZabbix();
                    if ($loginValido==""){
                        header("Location: index.php?codigo=-5" . '&user=' . $user);
                    }
                    else {
                    
                        $userDato = ZabbixAPI::fetch_array('user', 'get',
                            array('extendoutput' => 1, 'pattern' => $user));

                    // Iniciamos sesion
                    if (empty($userDato[0])) {
                        header("Location: index.php?codigo=-2" . '&user=' . $user);
                    } else {
                            // vaciarla
                        $_SESSION = array();
                            // destruirla
                        session_destroy();
                        session_start();
                        $_SESSION['datoUsuario'] = $userDato[0];
                        guarda_session();
                        $_SESSION['configuracionG'] =
                                configuracionGrupo($_SESSION['datoUsuario']['alias'],
                                        $_SESSION['datoUsuario']['userid']);
                        $_SESSION['configuracionH'] =
                                configuracionHOST($_SESSION['datoUsuario']['alias'],
                                        $_SESSION['datoUsuario']['userid']);

                        global $USER_API_ZABBIX;
                        global $PASS_API_ZABBIX;
                        $ret = ZabbixAPI::login($SERVER_ZABBIX, $USER_API_ZABBIX, $PASS_API_ZABBIX);
                        if ($ret!=""){

                        if (!is_null($_POST[url])) {
                            $_SESSION[url] = null;
                            $alertas = 0;
                            $identificado = 1;
                            header('Location: ' . $_POST[url]);
                        } else {
                            $identificado = 1;
                            header("Location: controlador.php?alerta=1");
                        }
                        }else {
                            require_once("errorLog.php");
                        }
                    }}
                } else {
                    header("Location: index.php?codigo=$codigo" . '&user=' . $user);
                }
            } else {
                header("Location: index.php?codigo=2" . '&user=' . $user);
            }
        } else {
            header("Location: index.php?codigo=1" . '&user=' . $user);
        }
    } else {
        header("Location: index.php?codigo=1" . '&user=' . $user);
    }
}


/* MREQUEST NO LOGIN */
/* This function is for link request */
function request_no_login()
{
    $url = $_SERVER[REQUEST_URI];
    $_SESSION[url] = $url;
    header("Location: index.php");
}


/* GET SCREENS LIST*/
/* This function return screens (with host graph) defined in zabbix */
function get_screens_list(){

    $ret = loginZabbix();
    if ($ret!=""){
    $scr = ZabbixAPI::fetch_array('screen','get',array(
        userid=> $_SESSION['datoUsuario']['userid'],
        output => 'extend',
        'sortfield' => "name",
        select_screenitems => 'refer'));
    $lhost = extraeArrayID($_SESSION['configuracionH']);
    
    $dato_screen = array();
    $i=0;

    foreach ($scr as $s){
        $scr_session = array();
        $scr_session[screenid] = $s[screenid];
        $scr_session[name] = $s[name];
        $scr_session[items] = $s[screenitems];

       $dato_screen[$i] = $scr_session;
       $i++;
    }

    $_SESSION["d_screens"]  = $dato_screen;


    header("Location: screens.php");
    } else {

        require_once("errorLog.php");
        
    }

}



function get_screens(){
    $array_dir = array();
    $count=0;
    global $screenid;

    $_SESSION["screen_actual"][id]=$screenid;
    $screen_actual = array();
    $screen_actual[id]=$screenid;
    $ret = loginZabbix();
    if ($ret!=""){
    foreach ( $_SESSION["d_screens"][$screenid][items] as $item){


           if ($item[resourcetype]==0){
                $img = ZabbixAPI::fetch_array('graph','get',
                     array(graphids => array($item[resourceid]),
                         output => 'extend',
                         select_hosts => 'extend'));

             if (!in_array($img[0][hosts][0][hostid], $lhost)){
                $screen_actual[array_name2][$count] =$img[0][name];
                $screen_actual[array_name][$count] =$img[0][hosts][0][host];
                $screen_actual[array_id][$count] =$img[0][graphid];


                $directorioGraf = "graficas/grafica" .$item[resourceid]. time().'.png';
                if((strstr($_SERVER['HTTP_USER_AGENT'],'Mobile')==false)||
                    strstr($_SERVER['HTTP_USER_AGENT'],'iPad')==true){
                    $directorioGraf =
                        devolve_grafica($item[resourceid],$directorioGraf,500,400,3600);
                } else {
                    $directorioGraf =
                        devolve_grafica($item[resourceid],$directorioGraf,220,150,3600);
                }

                $array_dir[$count] = $directorioGraf;
                $count++;

              }
           }
    }
    $_SESSION["screen_actual"]=$screen_actual;
    

    $_SESSION["dir_screens"] = $array_dir;


    header("Location: screens.php?#lista");

    } else {

        require_once("errorLog.php");
        
    }
}






/**************************************************************************************************/
/* MAIN CONTROLLER ********************************************************************************/
/* This is the main code in the controller.php. The request is served here. */

/* If user session exists and it is valid */
if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {
    $defecto = TRUE;
    /* send ack for Host */
    if (!is_null($ack)&&(!is_null($eventid)))
    {
        $defecto = FALSE;
        send_ack();
    }
    /* Search hosts/host groups */
    else if ((!is_null($nuevaBusq))||
        (!is_null($_GET['campoBusqHost'])&&!is_null($_GET['campoBusqGrupo'])))
    {
        $defecto = FALSE;
        get_host_list();
    }
    /* Return information about particular host */
    else if (!is_null($_GET['idhost'])&&!is_null($_GET['host'])&&!is_null($_GET['ip'])
        &&!is_null($_GET['grupo']))
    {
        $defecto = FALSE;
        get_host_inf();
    }
    /* Execute  PING command in selected host */
    else if (!is_null($comandoPING))
    {
        $defecto = FALSE;
        make_PING();
    }
    /* Execute  TRACEROUTE command in selected host */
    else if (!is_null($comandoTRACE))
    {
        $defecto = FALSE;
        make_TRACEROUTE();
    }
    /* Generate grafics and return directories by a particular host */
    else if (!is_null($grafica)) {
        $defecto = FALSE;
        get_GRAPHS();
    }
    /* this function will call in a dynamic request for generate grafics and return graphs */
    else if (!is_null($_GET['graficaDinamica'])) {
        $defecto = FALSE;
        return_dynamic_graph();
    }
    /* Go to tools page */
    else if(!is_null($tools)){
        $defecto = FALSE;
        go_tools();
    }
    /* Out of page */
    else if (!is_null($logout)){
        $defecto = FALSE;
        logout();
    }
    /* Go to settings page */
    else if (!is_null($configuracion)){
        $defecto = FALSE;
        settings();
    }
    /* enable/disable sms option for particular host */
    else if (!is_null($sms)){
        $defecto = FALSE;
        set_sms_host();

    }
    /* filter/defilter one or more host/groups */
    else if (!is_null($ggfilter)||!is_null($gfilter)){
        $defecto = FALSE;
        filter_defilter();
    }
    else if (!is_null($screens)) {
        $defecto = FALSE;
        get_screens_list();
    }
    else if (!is_null($screenid)) {
        $defecto = FALSE;
        get_screens();
    }



    /* go to dashboard pages. This function extract issues information of zabbix */
    if (!is_null($alert)&&($alert==1)){
        $defecto = FALSE;
        go_to_dashboard();
    }

    if ($defecto == TRUE) {
        go_to_dashboard();
    }

}
/* If user session didn't exist, we need  identify ourself in login page */
else if (is_null($_SESSION['datoUsuario'])&&(comproba_session()==FALSE)&&
        !is_null($user)&&
        !is_null($pass)){

        login();

}
/* If user session didn't exist, and user variables neither, this request can be
 * a link request. It redirects to index. */
else if (is_null($_SESSION['datoUsuario'])&&(comproba_session()==FALSE)&&
        is_null($user)&&
        is_null($pass)) {
        request_no_login();
}


/* denied access */
else {
    require_once("errorSession.php");
} 

php?> 