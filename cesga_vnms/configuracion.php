<?php
    session_start();
    require_once("cabecera.php");
    //require_once("ZabbixAPI.class.php");
    require_once("funcionsSeguridade.php");
    require_once("funcionsWEB.php");


if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {

php?>


<body>
<div data-role="page" data-theme="b" id="home" data-title="Page Settings">
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"
                   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="content" name="main">

            <h4 id="tituloSeccion">  Settings </h4>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="#filterH" data-transition="slide">
                        <img  class="ui-li-icon" src="img/1319537315_onebit_33.png" />
                        Hosts filter</a></li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li><a href="#filterG" data-transition="slide">
                        <img  class="ui-li-icon" src="img/1319537315_onebit_33.png" />
                        Groups filter</a></li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li><a href="#info" data-transition="slide">
                        <img  class="ui-li-icon imagenIcon" src="img/1319621265_info_blue.png" />
                        About </a></li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li><a href="#links" data-transition="slide">
                        <img  class="ui-li-icon imagenIcon" src="img/1319621456_emblem-symbolic-link.png" />
                        Links</a></li>
            </ul>
    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" class="proba" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1"
                           data-transition="slide" rel="external"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                          class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           >Tools</a></li>
                    <li><a id="config2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado">Settings</a></li>
                </ul>
            </div>
    </div>

</div>

<div data-role="page" data-theme="b" id="filterH" data-title="Page Host filter">
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="content" name="main">

           <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="controlador.php?configuracion=1" rel="external" data-transition="slide">
                        Back to Settings Menu
                    </a>
                </li>
            </ul>
            <center>
        <h4 id="tituloSeccion">  Host filter </h4>

        <?php if (!empty($_SESSION['ListaGrupos'][0])) { php?>
           <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
               <li data-role="list-divider"role="heading">
                   Search group
               </li>
                      <?php

                          foreach ($_SESSION['ListaGrupos'] as $grupo){
                             $cadena = '<li  data-role="fieldcontain"><a href="#'
                              .$grupo[name].'">'. $grupo[name] .'</a></li>';
                               echo $cadena;
                         }    php?>

            </ul>
        <?php } else { php?>
              <br/><br/>
              <center>
                  <img alt="Host list empty" src="img/1322036426_trashcan_empty.png" />
                  <p> Host list empty </p>
              </center>

        <?php } php?>
                   </center>

    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" rel="external"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                          class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           >Tools</a></li>
                    <li><a id="config2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado">Settings</a></li>
                </ul>
            </div>
    </div>

</div>

    <?php
$cont = 0;
foreach ($_SESSION['ListaGrupos'] as $grupo){ php?>
<div data-role="page" data-theme="b" id="<?php echo $grupo[name]; php?>" data-title="Page Host filter">
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="content" name="main">

           <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="controlador.php?configuracion=1" rel="external" data-transition="slide">
                        Back to Settings Menu
                    </a>
                </li>
            </ul>

        <h4 id="tituloSeccion">  Host filter </h4>

            <?php
                $listHOST = $grupo[hosts]; php?>
             <form  
                        name="filtraHost" data-ajax="false"
                  method="POST" action="controlador.php">
              <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    <?php echo 'GROUP: '.$grupo[name]; php?>
                    <input type="hidden" value="<?php echo $grupo[groupid]; php?>" name="groupHostFilt"/>
                </li>
                <li>
                        <input class="filtro" type="submit" data-theme="a" value="Filter"/>
                </li>
                <li>
                <?php
                php?>

                <fieldset data-role="controlgroup">
                <?php
                $cont2=0;
                if (count($listHOST)<1){
                    echo '<center><li> <p> EMPTY </p> </li></center>';
                } else {
                    foreach ($listHOST as $h){ php?>

                            <input type="checkbox" name="filtraH[]"
                                   value="<?php echo $h[hostid]; php?>" data-theme="d"
                                   id="HFradio-choice-<?php echo $cont2; php?>"
                            <?php if (in_array($h[hostid],$_SESSION['FiltradosH'])==TRUE){
                                    echo ' checked ';
                            }
                            php?>
                            />

                        <label style="white-space:normal!important;"
                               for="HFradio-choice-<?php echo $cont2; php?>">
                        <?php echo $h[host]." : ".$h[ip]; php?>
                        </label>


                        <?php
                        $cont2++;
                    }
                }


                php?>
                </fieldset>
                </li>
                <li>
                        <input class="filtro" type="submit" data-theme="a" value="Filter"/>
                </li>
               </ul>
              </form>
                <?php
                $cont++;
            php?>


    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" rel="external"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                          class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           >Tools</a></li>
                    <li><a id="config2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado">Settings</a></li>
                </ul>
            </div>
    </div>

</div>
<?php } php?>



<div data-role="page" data-theme="b" id="filterG" data-title="Page Group filter">
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="content" name="main">

           <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="controlador.php?configuracion=1" data-theme="c" data-transition="slide">
                        Back to Settings Menu
                    </a>
                </li>
            </ul>

        <h4 id="tituloSeccion">  Group filter </h4>




        <?php

        if (!empty($_SESSION['ListaGruposH'][0])) { php?>
            <form id="busquedaHost" name="filtraGrupo" data-ajax="false"
                  method="POST" action="controlador.php" rel="external">
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    Groups List
                    <input type="hidden" value="1" name="groupFilt"/>
                </li>
                <li>
                        <input class="filtro"  type="submit" data-theme="a" value="Filter"/>
                </li>

                <li>
                <fieldset data-role="controlgroup">
            <?php
            $cont = 0;
            foreach ($_SESSION['ListaGruposH'] as $grouplist) { php?>

            <input
                   type="checkbox" name="filtraG[]" value="<?php echo $grouplist[groupid]; php?>" data-theme="d"
                   id="GFradio-choice-<?php echo $cont; php?>"
                   <?php if (in_array($grouplist[groupid],$_SESSION['FiltradosG'])==TRUE){
                        echo ' checked ';
                     }
                   php?>
                   />
            <label style="white-space:normal!important;" for="GFradio-choice-<?php echo $cont; php?>">
                <?php echo $grouplist[name]; php?></label>

            <?php
            $cont++;
            } php?>
                    </fieldset>
                    </li>
                    <li>
                        <input class="filtro"  type="submit" data-theme="a" value="Filter"/>
                    </li>
                    </ul>
            </form>
               <?php } else {php?>
              <br/><br/>
              <center>
                  <img alt="Group list empty" src="img/1322036426_trashcan_empty.png" />
                  <p> Group list empty </p>
              </center>

            <?php
            } php?>

    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" rel="external"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                          class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           >Tools</a></li>
                    <li><a id="config2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado">Settings</a></li>
                </ul>
            </div>
    </div>

</div>


<div data-role="page" data-theme="b" id="info" data-title="Page About" >
    <div data-role="header" id="info" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
<a data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">
                    Logout
                </a>

    </div>


    <div style="text-align: justify;" data-role="content" id="content" name="main" data-theme="b">
            <h4 id="tituloSeccion">  About </h4><br/>

                <ul data-role="listview" data-inset="true" 
                    data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    Product Overview
                </li>
                <li><p style="text-align: justify;font-size: 14px;white-space:normal!important;">
CESGA VNMS is a light web client for Zabbix network monitoring tool developed by CESGA (Galicia Supercomputing Center). It has been targeted to mobile clients. It allows the following functionalities:
<br/>
                    </p>
                    <p style="font-size: 14px;white-space:normal!important;">
&nbsp;&nbsp;- <b>Display issues</b> (last issues and active issues, ordered or not by group).
<br/>
&nbsp;&nbsp;- <b>Display host information</b> (searchable by host it retrieves IP, group, issues, graphs and allows basic checks like ping or traceroute).
<br/>
&nbsp;&nbsp;- <b>Display screen information</b> (graphs groups from different hosts defined in ZABBIX interface).
<br/>
&nbsp;&nbsp;- <b>Provides network query tools</b> like nslookup, whois, ping, traceroute, etc. to any IP address/port.
<br/>
                </p></li>
                </ul>
                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    Supported platforms
                </li>
                <li>
                    <p style="text-align: justify;font-size: 14px;white-space:normal!important;">
CESGA VNMS has been deployed in CentOS release 5.7 (Final), and it has been tested on
the following platforms: <br/></p>
                    <p style="font-size: 14px;white-space:normal!important;">
&nbsp;&nbsp;<b>- Google Android 2.3.</b><br/>
&nbsp;&nbsp;<b>- Apple IOS 4 and 5 </b>(Iphone and Ipad).<br/>
&nbsp;&nbsp;<b>- Amazon Kindle</b> <br/><br/>
                    </p>
                    <p style="text-align: justify;font-size: 14px;white-space:normal!important;">
Besides, it is a normal web application, therefore it has been tested on:<br/>
                    </p>
                    <p style="font-size: 14px;white-space:normal!important;">
&nbsp;&nbsp;<b>- Firefox 8.0</b><br/>
&nbsp;&nbsp;<b>- Google Chrome 15.0.874.106</b><br/>
&nbsp;&nbsp;<b>- Internet Explorer 9 </b><br/>
                    </p>
                </li>
                </ul>

                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    License
                </li>
                <li>
<p style="text-align: justify;font-size: 14px;white-space:normal!important;">

CESGA VNMS docs is released under Open Source Initiative OSI – The MIT License (MIT).<br/>
For additional details, including answers to common questions about The MIT License, go
to <a href="http://www.opensource.org/licenses/mit-license.php">
    http://www.opensource.org/licenses/mit-license.php </a><br/>

</p>
                </li>
                </ul>



    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" rel="external"
                           > Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           class="">Tools</a></li>
                    <li><a id="config2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado">Settings</a></li>
                </ul>
            </div>
    </div>

 </div>




<div data-role="page" data-theme="b" id="links" data-title="Page Links">
    <div data-role="header" id="info" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
<a data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">
                    Logout
                </a>

    </div>


    <div style="text-align: justify;" data-role="content" id="content" name="main" data-theme="b">
            <h4 id="tituloSeccion">  External links </h4>
            <ul data-theme="c" data-role="listview" data-inset="true">
                <li>
                    <a href="http://www.cesga.es/" data-transition="slide"  data-ajax="false" rel="external">
                        CESGA
                    </a>
                </li>
                <li>
                    <a href="http://www.zabbix.com/" data-transition="slide"  data-ajax="false" rel="external">
                        ZABBIX
                    </a>
                </li>
            </ul>




    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" rel="external"
                           class="ui-state-persists  activado"> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" rel="external"
                           class="">Monitoring</a></li>
                    <li><a id="tools" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  rel="external"
                           class="">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" rel="external"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

 </div>




 <?php
} else {
     require_once("errorSession.php");
}
php?>

</body>
</html>