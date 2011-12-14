<?php
    session_start();
    require_once("cabecera.php");
    //require_once("ZabbixAPI.class.php");
    require_once("funcionsSeguridade.php");
    require_once("funcionsWEB.php");
    

if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {

php?>


<div data-role="page" data-theme="b" id="home" data-title="Host page">
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div style="margin-top:4px;"data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active" href="#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide"  href="#issues" >Issues</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#traps" >Logs</a></li>
                    </ul>
           </div>

    </div>

    <div data-role="content" id="content" name="main">

 <?php //metendoEspacios(); php?>
        <ul data-role="listview" data-inset="true" data-theme="d">
            <li data-role="list-divider"role="heading" > Host Info </li>
            <li><span class="hostcampo">Host : </span>
                <span class="hostcampo2"> <?php echo $_GET["host"]; php?></span></li>
            <li><span class="hostcampo">IP : </span>
                <span class="hostcampo2"> <?php echo $_GET["ip"]; php?></span></li>
            <li><span class="hostcampo">Group : </span>
                <span class="hostcampo2"> <?php echo $_GET["grupo"]; php?></span></li>
        </ul>

       <?php if ($_SESSION['datoUsuario']['type'] == 3){ php?>
        <ul data-role="listview" data-inset="true" data-theme="d">
            <li>

        <?php if ($_GET[sms]=="Activado"){ php?>
                <a  data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $_GET['host'].'&enable=0'; php?>
                   " data-theme="d" " style="color:#75170A; width:150px;font-size: 13px;">Disable SMS</a>

        <?php } else  { php?>

                <a  data-ajax="false" data-transition="slide" href="
                   <?php echo  'controlador.php?sms=1&host='.
                $_GET['host'].'&enable=1'; php?>
                   " data-theme="d"  style="color:#21750A; width:150px;font-size: 13px;">Enable SMS</a>

        <?php } php?>
            </li>
        </ul>
       <?php } php?>




        <?php $profile = $_SESSION['profile'][0];
              if ((!is_null($profile['poc_1_name'])&&($profile['poc_1_name']!=""))||
                 ((!is_null($profile['poc_1_email']))&&($profile['poc_1_name']!=""))||
                 ((!is_null($profile['poc_1_phone_1']))&&($profile['poc_1_name']!=""))||
                 ((!is_null($profile['poc_2_name']))&&($profile['poc_1_name']!=""))||
                 ((!is_null($profile['poc_2_email']))&&($profile['poc_1_name']!=""))||
                 ((!is_null($profile['poc_2_phone_1']))&&($profile['poc_1_name']!=""))) { php?>
            

        <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
            <li data-role="list-divider"role="heading">
                Profile 1 : <?php echo $profile['poc_1_name']; php?>
            </li>
            <li><span class="hostcampo">email : </span>
                <span class="hostcampo2">
                    <?php echo $profile['poc_1_email']; php?>
                </span>
            </li>
            <li><a href="tel:<?php echo $profile['poc_1_phone_1']; php?>">
                <span class="hostcampo">telefono : </span>
                <span class="hostcampo2">
                    <?php echo $profile['poc_1_phone_1']; php?>
                </span>
                </a>
            </li>
        </ul>

        <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="c">
            <li data-role="list-divider"role="heading">
                Profile 2 : <?php echo $profile['poc_2_name']; php?>
            </li>
            <li><span class="hostcampo">email : </span>
                <span class="hostcampo2">
                    <?php echo $profile['poc_2_email']; php?>
                </span>
            </li>
            <li><a href="tel:<?php echo $profile['poc_2_phone_1']; php?>"><span class="hostcampo">telefono : </span>
                <span class="hostcampo2">
                    <?php echo $profile['poc_2_phone_1']; php?>
                </span>
                </a>
        </ul>

        <?php } php?>
    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>


<div data-role="page" data-theme="b" id="issues" data-title="Host page">
    <div data-role="header" id="hdrIssues" name="hdrIssues"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div style="margin-top:4px;"data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="a" data-transition="slide" href="#home" >Details</a></li>
			<li><a  data-theme="b" data-transition="slide" class="ui-btn-active" href="#issues" >Issues</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentIssues" name="mainIssues">
        
        
<?php if (!is_null($_SESSION['hostDatos'][0][triggerid])) {

php?>

    <ul data-role="listview" data-theme="d" data-inset="true" data-split-theme="d" data-split-icon="delete">
        <li data-role="list-divider"role="heading" > Active Issues - <?php echo $_GET["host"]; php?> </li>
    <?php
    foreach($_SESSION['hostDatos'] as $trigger) {
        php?>

      <li data-theme="d" style="white-space:normal!important;">

            <img class="alertaIMG2"
                 src=<?php echo prioridad_trigger($trigger['priority']); php?> />
            <?php  $mensajeAlerta = str_replace('{HOSTNAME}', $trigger[host], $trigger[description]); php?>
            <p class="alertap">
                <br/>
                <b>Issue: </b><?php echo $mensajeAlerta;php?>
                <br/>
                <b>Last change: </b><?php echo   date("H",$trigger[clock]).":".
                                          date("i",$trigger[clock])." ".
                                          date("G",$trigger[clock])."/".
                                          date("m",$trigger[clock])."  "; php?>
            </p>

      </li>
    <?php
    } php?>
        </ul>
<?php } else { php?>
             
             <center>
                 <h4 id="tituloSeccion">  Host - <?php echo $_GET["host"]; php?> </h4>
                       <img src="img/1318843688_button_ok.png" alt="NO issues"/>
                       <p> No active issues </p>

             </center>


            
<?php      }
php?>
    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>


<div data-role="page" data-theme="b" id="graphs" data-title="Host page">
    <div data-role="header" id="hdrGraphs" name="hdrGraphs"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div  data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="a" data-transition="slide" href="#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide" href="#issues" >Issues</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#checks" >Checks</a></li>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active"href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">
       <?php
       if((!empty($_SESSION['graficas'][0]))) { php?>

        <h4 class="tituloSeccion2">  <?php echo $_GET['host'].'<br/> Graph List'; php?> </h4>
  
        <form rel="external" data-ajax="false"  method="POST" action="controlador.php?grafica=1&<?php echo 'hostid='
        .$_GET['hostid'].'&host='.$_GET['host'].'&ip='.$_GET['ip']
                        .'&grupo='.$_GET['grupo']; php?>">

        
        <div data-role="fieldcontain">
            <div data-role="controlgroup" data-theme="c">

                <?php  for ($i = 0; $i <= count($_SESSION['graficas']); $i++) { php?>
                    <?php if ( $_SESSION['graficas'][$i]['graphid']!="") { php?>
                <input type="checkbox" data-theme="c" name="grafics[]"
                       value="<?php echo  $_SESSION['graficas'][$i]['graphid'].'_'.
                                          $_SESSION['graficas'][$i]['name']; php?>"
                       id="<?php echo     $_SESSION['graficas'][$i]['graphid'].'_'.
                                          $_SESSION['graficas'][$i]['name']; php?>" class="custom" />
                <label for="<?php echo    $_SESSION['graficas'][$i]['graphid'].'_'.
                                          $_SESSION['graficas'][$i]['name']; php?>">
                    <?php echo $_SESSION['graficas'][$i]['name']; php?>
                    <?php } php?>
                </label>
                <?php } php?>

            </div>
        </div>
        <input type="submit" rel="external" data-ajax="false" 
               data-transition="slide" 
               value="Watch selected graphs" data-theme="a"/>
        </form>

        <?php } else { php?>
              <h4 class="tituloSeccion2">  <?php echo $_GET['host'].'<br/> Graph List'; php?> </h4>
              <br/><br/>
              <center>
                  <img alt="Log list empty" src="img/1322036426_trashcan_empty.png" />
                  <p> Graph list empty </p>
              </center>
        <?php }  php?>


       
    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>


<div data-role="page" data-theme="b" id="checks" data-title="Host page">
    <div data-role="header" id="hdrChecks" name="hdrCheks"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div style="margin-top:4px;"data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="a" data-transition="slide" href="#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide" href="#issues" >Issues</a></li>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active" href="#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">
 <?php //metendoEspacios(); php?>

        <ul data-role="listview" data-inset="true" data-theme="c">


                <li style="white-space:normal!important;"
                    data-role="list-divider"role="heading" > Check host - <?php echo $_GET["host"]; php?></li>
                <li style="white-space:normal!important;">
                    <a class="estiloToolsHost" rel="external"
                       href="controlador.php?<?php echo 'executaPing=1&hostid='. $_GET['hostid'].
                             '&host='.$_GET['host'].'&ip='.$_GET['ip'].'&grupo='.$_GET['grupo']; php?>"
                       data-transition="slide">Make Ping</a></li>
                <li style="white-space:normal!important;">
                    <a class="estiloToolsHost" rel="external"
                       href="controlador.php?<?php echo 'executaTrace=1&hostid='. $_GET['hostid'].
                        '&host='.$_GET['host'].'&ip='.$_GET['ip'].'&grupo='.$_GET['grupo']; php?>"
                       data-transition="slide">Make Traceroute</a></li>
        </ul>
    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>



<div data-role="page" data-theme="b" id="traps" data-title="Host page">
    <div data-role="header" id="hdrtraps" name="hdrTraps"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div  data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="a" data-transition="slide" href="#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide" href="#issues" >Issues</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active"href="#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">


        <h4 class="tituloSeccion2">  <?php echo $_GET['host'].'<br/> Log list'; php?> </h4>


           <?php

           if (!empty($_SESSION[TRAPS])) { php?>
           
           
           
           <ul data-role="listview" data-inset="true" data-theme="d">
                <?php
                  foreach ($_SESSION[TRAPS] as $trap){ php?>

                       <li>
                           <a  data-transition="slide" href="#p<?php echo  $trap[id]; php?>" >
                           <?php echo  $trap[des]; php?>
                           </a>
                       </li>
                <?php }    php?>
            </ul>
            <?php

            } else { php?>
              <br/><br/>
              <center>
                  <img alt="Log list empty" src="img/1322036426_trashcan_empty.png" />
                  <p> Log list empty </p>
              </center>

            <?php 
            } php?>
    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>


<?php foreach ($_SESSION[TRAPS] as $trap){ php?>

<div data-role="page" data-theme="b" id="p<?php echo $trap[id]; php?>" data-title="Host page">
    <div data-role="header" id="<?php echo $trap[id]; php?>" name="<?php echo $trap[id]; php?>"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
           <div  data-role="navbar"data-theme="a" >
                    <ul>
                        <li><a  data-theme="a" data-transition="slide" href="#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide" href="#issues" >Issues</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide" href="#graphs" >Graphs</a></li>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active" href="#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">


        <h4 class="tituloSeccion2">  <?php echo $_GET['host'].'<br/> Log list'; php?> </h4>



        <div data-role="fieldcontain">
           <ul data-role="listview" data-inset="true" data-theme="d">
                    

                <li style="white-space:normal!important;"
                    data-role="list-divider"role="heading" >
                        <?php echo $trap[des];php?>

                </li>
                <?php for($i=0;$i< count($trap[datos]); $i++){ php?>
                <li style="white-space:normal!important;" data-theme="b">
                    <?php
                         echo $trap[datos][$i][0].'<pre style="white-space:normal!important;">';
                         echo $trap[datos][$i][1];
                         echo '</pre>';
                     php?>
                </li>
                <?php } php?>


            </ul>
        </div>


    </div>

<?php if ($_SESSION['estaEnAlerta']==0){ php?>

    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                           > Dashboard
                        </a></li>
                    <li><a id="host2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                           class="ui-state-persists  activado">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } else { php?>
    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          >Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>
<?php } php?>

</div>

<?php } php?>



 <?php
} else {
     require_once("errorSession.php");
}
php?>

</body>
</html>
