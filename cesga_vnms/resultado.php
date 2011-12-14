<?php
    session_start();
    require_once("cabecera.php");
    require_once("funcionsSeguridade.php");
    
if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {
php?>


<div data-role="page" data-theme="b" id="resultados" >
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
                        <li><a  data-theme="a" data-transition="slide"
                                rel="external"
                                href="<?php echo "host.php?host="
                                    .$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
                                    .'&hostid='.$_GET['hostid']; php?>#home" >Details</a></li>
			<li><a  data-theme="a" data-transition="slide"
                                rel="external"
                                href="<?php echo "host.php?host="
                                    .$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
                                    .'&hostid='.$_GET['hostid']; php?>#issues" >Issues</a></li>
                        <li><a  data-theme="b" data-transition="slide" class="ui-btn-active"
                                rel="external"
                                href="<?php echo "host.php?host="
                                    .$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
                                    .'&hostid='.$_GET['hostid']; php?>#checks" >Checks</a></li>
                        <li><a  data-theme="a" data-transition="slide"
                                rel="external"
                                href="<?php echo "host.php?host="
                                    .$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
                                    .'&hostid='.$_GET['hostid']; php?>#graphs" >Graphs</a></li>
                        <li><a  data-theme="a" data-transition="slide"
                                rel="external"
                                href="<?php echo "host.php?host="
                                    .$_GET['host']."&ip=".$_GET['ip']."&grupo=".$_GET['grupo']
                                    .'&hostid='.$_GET['hostid']; php?>#traps" >Logs</a></li>
                    </ul>
           </div>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">


        <ul data-role="listview" data-inset="true" data-theme="d">


                <li style="white-space:normal!important;"
                    data-role="list-divider"role="heading" >
                    <?php if (!is_null($_SESSION['mensaje'])&&($_GET['ping']==1)){ php?>
                    Ping to <?php echo $_GET['host']; php?>
                    <?php } else if (!is_null($_SESSION['mensaje'])&&($_GET['trace']==1)){ php?>
                    Traceroute to <?php echo $_GET['host']; php?>
                    <?php } php?>

                </li>
                <li data-theme="d" style="white-space:normal!important;" data-theme="b">
                    <?php
                            if (!is_null($_SESSION['mensaje'])&&($_SESSION['mensaje']!="")){
                                echo '<pre style="white-space:normal!important;">'.
                                $_SESSION['mensaje'].'</pre>';
                            } else {
                                echo "Error when command was executed";
                            }

                     php?>
                </li>
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



<?php 
} else {

     require_once("errorSession.php");
}
php?>

</body>
</html>
