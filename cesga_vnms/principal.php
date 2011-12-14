<?php

session_start();
require_once("cabecera.php");
//require_once("ZabbixAPI.class.php");
require_once("funcionsSeguridade.php");
require_once("funcionsWEB.php");

// deserializamos
$alerts = $_SESSION['alert'];
$groups = $_SESSION['gruposItem'];

php?>
<body>
<?php
if (!is_null($_SESSION['datoUsuario'])&&(comproba_session()==TRUE)) {

    php?>


<div data-role="page" data-theme="b" id="home" >
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                        <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">
                    Logout
                </a>
    </div>


    <div data-role="content" id="content" name="main" data-theme="b">
            <h4 id="tituloSeccion">  Dashboard </h4>

            <ul data-role="listview" data-inset="true" data-theme="c">
                <li><a href="#allgroup" data-transition="slide">
                        <img  class="ui-li-icon imagenIcon" src="img/1319538322_folder_important.png" />
                        Issues ordered by hostgroup</a></li>
            </ul>

            <br/>
            <ul data-role="listview" data-inset="true" data-split-theme="d" data-split-icon="delete"
                 data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    Last 20 issues
                </li>
    <?php


    if (!is_null($_SESSION['lastAlert'][0][hostid])){

    $cont = 0;
    foreach($_SESSION['lastAlert'] as $alert) {
        $cont++;


        
        php?>



      <li id="<?php echo $alert[triggerid]; php?>"style="white-space:normal!important;">


        <a  data-transition="slide" rel="external" href="<?php
                    echo 'controlador.php?alertaHost=1&idhost='
                   .$alert[hostid].'&host='.$alert[host].'&ip='.$alert[ip].'&grupo='.$alert[name];
            php?>
            " class="alerta">
            <img class="alertaIMG"
                 src=<?php echo prioridad_trigger($alert['priority']); php?> />
            <h3 class="alertah3">
                <b>Host: </b> <?php echo $alert['host'];php?></h3>
            <p class="alertap">
                <b>ip: </b><?php echo $alert['ip'];php?> </p>
            <?php  $mensajeAlerta = str_replace('{HOSTNAME}', $alert[host], $alert[description]); php?>
            <p class="alertap">
                <b>Issue: </b><?php echo $mensajeAlerta;php?></p>
            <p class="alertap">
                <b>Last change: </b><?php echo   date("G",$alert[clock]).":".
                                          date("i",$alert[clock])." ".
                                          date("j",$alert[clock])."/".
                                          date("n",$alert[clock])."/".
                                          date("Y",$alert[clock]).""; php?>
            </p>

            <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
            <p class="alertap" style="color:#21750A;">
                <?php if ($alert[acknowledged]!=0){ php?>
                    <b>ACK: </b> &nbsp Enviado
                <?php } php?>
            </p>
            <?php } php?>


        </a>



        <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
        <?php if ($alert[acknowledged]==0){ php?>
        <p class="ackdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="<?php echo  'controlador.php?ack=1&eventid='.
                $alert['eventid'].'&division='.$alert[triggerid]; php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Send ACK</a>
        </p>
        <?php } php?>

        <?php if ($alert[sms]=="Activado"){ php?>
        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="<?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=0&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Disable SMS</a>
        </p>
        <?php } else  { php?>

        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="<?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=1&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#21750A; width:150px;font-size: 13px;">Enable SMS</a>
        </p>
        <?php } php?>
        <?php } php?>
      </li>
    <?php
    }
       if ($cont>19) {
    php?>
      <li><a href="#lastIssues" data-transition="slide">
           <img  class="ui-li-icon imagenIcon" src="img/1319538463_dialog-warning.png" />
                    &nbsp&nbsp    Display All
          </a>
      </li>
    
   <?php
       }
    }
    else { php?>
      <li>
                       <img  class="ui-li-icon imagenIcon"
                             src="img/1318843688_button_ok3.png" alt="NO issues"/>
                       No active issues 
      </li>
    <?php } php?>
        </ul>

    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

 </div>


<div style="position:relative!important;"
     id="lastIssues"  data-role="page" data-theme="b" >

    <div data-role="header" id="hdrMain" name="hdrMain" data-backbtn="true"
         data-position="fixed" data-theme="b" data-position="inline">
        <a data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1" data-transition="slide"
                   class="botonLogut" data-ajax="false">Logout</a>

    </div>

    <div data-role="content" id="content" name="main" data-theme="b">
      <h4 id="tituloSeccion">  Active issues by date</h4>
        <ul data-role="listview" data-inset="true" 
            data-split-theme="d" data-split-icon="delete"
            data-theme="c">
    <?php
    if (!is_null($_SESSION['lastAlert'][0][hostid])){
    foreach($_SESSION['dataAlert'] as $alert) {
        php?>

      <li id="<?php echo $alert[triggerid]; php?>"style="white-space:normal!important;">


        <a  data-transition="slide" rel="external" href="<?php
                    echo 'controlador.php?alertaHost=1&idhost='
                   .$alert[hostid].'&host='.$alert[host].'&ip='.$alert[ip].'&grupo='.$alert[name];
            php?>
            " class="alerta">
            <img class="alertaIMG"
                 src=<?php echo prioridad_trigger($alert['priority']); php?> />
            <h3 class="alertah3">
                <b>Host: </b> <?php echo $alert['host'];php?></h3>
            <p class="alertap">
                <b>ip: </b><?php echo $alert['ip'];php?> </p>
            <?php  $mensajeAlerta = str_replace('{HOSTNAME}', $alert[host], $alert[description]); php?>
            <p class="alertap">
                <b>Issue: </b><?php echo $mensajeAlerta;php?></p>
            <p class="alertap">
                <b>Last change: </b><?php echo   date("G",$alert[clock]).":".
                                          date("i",$alert[clock])." ".
                                          date("j",$alert[clock])."/".
                                          date("n",$alert[clock])."/".
                                          date("Y",$alert[clock]).""; php?>
            </p>
            <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
            <p class="alertap" style="color:#21750A;">
                <?php if ($alert[acknowledged]!=0){ php?>
                    <b>ACK: </b> &nbsp Enviado
                <?php } php?>
            </p>
            <?php } php?>


        </a>



        <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
        <?php if ($alert[acknowledged]==0){ php?>
        <p class="ackdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?ack=1&eventid='.
                $alert['eventid'].'&division='.$alert[triggerid]; php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Send ACK</a>
        </p>
        <?php } php?>

        <?php if ($alert[sms]=="Activado"){ php?>
        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=0&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Disable SMS</a>
        </p>
        <?php } else  { php?>

        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=1&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#21750A; width:150px;font-size: 13px;">Enable SMS</a>
        </p>
        <?php } php?>
        <?php } php?>
      </li>
    <?php
    }
    } else {php?>
      <li>
                       <img  class="ui-li-icon imagenIcon"
                             src="img/1318843688_button_ok3.png" alt="NO issues"/>
                       No active issues
      </li>
    <?php
    }
        php?>
        </ul>
    </div>


    <div  data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1" data-transition="slide" data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

</div>




<div data-role="page" data-theme="b" id="allgroup" >
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>

    </div>


    <div data-role="content" id="content" name="main" data-theme="b">
 <?php
 // Para cada grupo
if (!is_null($_SESSION['lastAlert'][0][hostid])){
 php?>
      <h4 id="tituloSeccion">  Active issues by host groups </h4>
      <ul data-role="listview" data-inset="true" data-theme="c">
      <?php foreach ($groups as $group){
              $division='#alertas'.$group[grupo];
          php?>
        <li><a href="#alertas<?php echo $group[grupo]; php?>"
               data-transition="slide"><?php echo $group[grupo]; php?></a>
            <span class="ui-li-count">
                <?php echo $group[num]; php?>
            </span></li>
       <?php } php?>
      </ul>  
<?php
 } else  { php?>
        <h4 id="tituloSeccion">  Active issues by host groups </h4>
      <ul data-role="listview" data-inset="true" data-theme="c">
      <li>
                       <img  class="ui-li-icon imagenIcon"
                             src="img/1318843688_button_ok3.png" alt="NO issues"/>
                       No active issues
      </li>
      </ul>
    <?php
 }
 php?>
    </div>

    
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

 </div>



<!-- This part is from alerts belonging to groups -->
<?php foreach ($groups as $group){ 
    php?>

<div style="position:relative!important;"
     id="alertas<?php echo $group[grupo];php?>" data-role="page" data-theme="b" >

    <?php $division='alertas'.$group[grupo]; php?>
    <div data-role="header" id="hdrMain" name="hdrMain" data-backbtn="true"
         data-position="fixed" data-theme="b" data-position="inline">
        <a data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1" data-transition="slide"
                   class="botonLogut" data-ajax="false">Logout</a>

    </div>

    <div data-role="content" id="content" name="main" data-theme="b">
        <ul data-role="listview" data-inset="true" data-split-theme="d" 
            data-split-icon="delete" data-theme="c">
    <?php
    foreach($alerts as $alert) {
        if (strcmp($alert['name'],$group['grupo'])==0){
        php?>

      <li style="white-space:normal!important;">

          
        <a  data-transition="slide" rel="external" href="<?php
                    echo 'controlador.php?alertaHost=1&idhost='
                   .$alert[hostid].'&host='.$alert[host].'&ip='.$alert[ip].'&grupo='.$alert[name];
            php?>
            " class="alerta">
            <img class="alertaIMG"
                 src=<?php echo prioridad_trigger($alert['priority']); php?> />
            <h3 class="alertah3">
                <b>Host: </b> <?php echo $alert['host'];php?></h3>
            <p class="alertap">
                <b>ip: </b><?php echo $alert['ip'];php?> </p>
            <?php  $mensajeAlerta = str_replace('{HOSTNAME}', $alert[host], $alert[description]); php?>
            <p class="alertap">
                <b>Issue: </b><?php echo $mensajeAlerta;php?></p>
            <p class="alertap">
                <b>Last change: </b><?php echo   date("G",$alert[clock]).":".
                                          date("i",$alert[clock])." ".
                                          date("j",$alert[clock])."/".
                                          date("n",$alert[clock])."/".
                                          date("Y",$alert[clock]).""; php?>
            </p>
            <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
            <p class="alertap" style="color:#21750A;">
                <?php if ($alert[acknowledged]!=0){ php?>
                    <b>ACK: </b> &nbsp Enviado
                <?php } php?>
            </p>
            <?php } php?>

        </a>



        <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
        <?php if ($alert[acknowledged]==0){ php?>
        <p class="ackdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?ack=1&eventid='.
                $alert['eventid'].'&division='.$division;php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Send ACK</a>
        </p>
        <?php } php?>

        <?php if ($alert[sms]=="Activado"){ php?>
        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=0&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#75170A; width:150px;font-size: 13px;">Disable SMS</a>
        </p>
        <?php } else  { php?>

        <p class="smsdiv">
                <a class="ack" data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $alert['host'].'&enable=1&desdeAlarma=1'; php?>
                   " data-theme="d" data-role="button" style="color:#21750A; width:150px;font-size: 13px;">Enable SMS</a>
        </p>
        <?php } php?>
        <?php } php?>
      </li>
    <?php 
        }
    } php?>
        </ul>
    </div>


    <div  data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1" data-transition="slide" data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

</div>
<?php } php?>

<?php
} else {
     require_once("errorSession.php");
} php?>

    </body>

</html>



