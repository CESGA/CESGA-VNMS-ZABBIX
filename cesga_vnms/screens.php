<?php
    session_start();
    require_once("cabecera.php");
    //require_once("ZabbixAPI.class.php");
    require_once("funcionsSeguridade.php");
    require_once("funcionsWEB.php");


if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {

php?>


<div data-role="page" data-theme="b" id="home" >
    <div data-role="header" id="hdrGraphs" name="hdrGraphs"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="contentGraphs" name="mainGraphs">
<?php 
        if(!is_null($_SESSION["d_screens"])&&
                $_SESSION["d_screens"][0][screenid]!="") { php?>
        

        <h4 class="tituloSeccion2">  Screens List </h4>

        <ul data-role="listview" data-inset="true" data-theme="c">
        <?php 
        $count= 0;
        foreach ($_SESSION["d_screens"] as $sc ) { php?>

                <li>
                    <a href="controlador.php?getscreens=<?php echo $count; php?>"
                       rel="external" data-transition="slide">
                        <?php echo $sc[name]; php?>
                    </a>
                </li>
        <?php 
                $count++;
                } php?>
        </ul>
        <?php } else { php?>
        <center>
              <h4 class="tituloSeccion2">  Screens List </h4><br/>

              <img src="img/1318575694_alert.png" alt="NO graph"/>
              <p> Screens aren't defined </p><br/>
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



<div data-role="page" data-theme="b" id="lista" >
    <div data-role="header" id="hdrChecks" name="hdrCheks"
         data-position="fixed" data-theme="b" data-position="inline" >
                <a data-transition="slide" data-rel="back" data-icon="arrow-l">Back</a>
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
                <a href="controlador.php?logout=1"
                   data-transition="slide"
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div  data-role="content" id="contentGraphs" name="mainGraphs">

        <div>
                <h4 class="tituloSeccion2">
                    <?php $j= $_SESSION["screen_actual"][id]; php?>
                     Screen <?php echo $_SESSION["d_screens"][$j][name]; php?>
                 </h4>
                <br/>
                <?php
                $i=0;
                foreach($_SESSION["dir_screens"] as $dir ) {
                    $id = $_SESSION["screen_actual"][array_id][$i];
                    $name = $_SESSION["screen_actual"][array_name][$i]." : ".
                    $_SESSION["screen_actual"][array_name2][$i];
                    $i++;
                    php?>


                <center>
                <h4 class="tituloSeccion2">
                    <?php echo $name; php?>
                 </h4>
                    <?php
                        //$img=file_get_contents("http://".$_SERVER['SERVER_NAME'].'/'.$dir);
                    php?>
                    <img id="graf<?php echo $id; php?>"
                    src="<?php echo $dir; php?>" alt="Grafica non cargada" >


                    <?php

                    if((strstr($_SERVER['HTTP_USER_AGENT'],'Mobile')==false)
                            ||strstr($_SERVER['HTTP_USER_AGENT'],'iPad')==true
                            ){ php?>


                    <div style="margin:0px;padding:0px;"data-role="navbar"data-theme="d"
                         data-grid="d">
                    <ul style="width: 600px;border-color: black!important;">
                        <li><a data-theme="c"
                               onclick="genera_grafica(<?php echo $id.
                               ",500,400,3600";php?>)" > 1h </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",500,400,43200";php?>)" > 12h </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",500,400,604800";php?>)" > 1w </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",500,400,2592000";php?>)" > 1m </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",500,400,15595200";php?>)" > 6m </a></li>
                    </ul>
                    </div>
                    <?php } else { php?>
                    <div style="margin:0px;padding:0px;"data-role="navbar"data-theme="d"
                         data-grid="d">
                     <ul style="width: 294px;border-color: black!important;">
                        <li><a data-theme="c"
                               onclick="genera_grafica(<?php echo $id.",220,150,3600";php?>)" > 1h </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.",220,150,43200";php?>)" > 12h </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",220,150,604800";php?>)" > 1w </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",220,150,2592000";php?>)" > 1m </a></li>
                        <li><a data-theme="c"
                            onclick="genera_grafica(<?php echo $id.
                               ",220,150,15595200";php?>)" > 6m </a></li>
                      </ul>
                    </div>
                    <ul style="width: 294px;" data-role="listview"
                        data-theme="c" data-inset="true">
                        <li>
                        <a href="#fullscreen"
                           onclick="fulls_creen('grafica',
                                                 <?php echo $id; php?>,400,350,3600)"
                           data-theme="c">
                            <img  style="margin-top:-5px;" class="ui-li-icon" src="img/1319543346_full_screen.png" />
                            Watch in fullscreen
                        </a>
                        </li>
                    </ul>
                    <?php }
                    php?>

                    <br/>
                </center>

                <?php } php?>


        <!--</ul>-->
        </div>
    </div>


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


</div>


<div <?php if((strstr($_SERVER['HTTP_USER_AGENT'],'Mobile')==false)
             ||strstr($_SERVER['HTTP_USER_AGENT'],'iPad')==true){ php?>
    style="width:100%!important;"
    <?php } else { php?>
    style="width:800px!important;"
    <?php } php?>
    data-role="page" data-theme="b" id="fullscreen" >
    <div <?php if((strstr($_SERVER['HTTP_USER_AGENT'],'Mobile')==false)
             ||strstr($_SERVER['HTTP_USER_AGENT'],'iPad')==true){ php?>
    style="width:100%!important;"
    <?php } else { php?>
    style="width:800px!important;"
    <?php } php?>
    data-role="header" id="hdrMain" name="hdrMain"
         data-theme="b" data-position="inline" >
        <a data-transition="slide" data-rel="back" data-icon="arrow-l">Return to Graph Menu</a>
        <h2 style="margin-bottom:20px;"> </h2>
    </div>

    <div  style="width:100%!important;"

          data-role="content" id="content" name="main" data-theme="b">
            <center>
            <h2 id="tituloSeccionGrafF"><b> Graph </b></h2>
            <center><img id="imagenFullGraf" src="" /></center>
            <input id="idgrafF" type="hidden" value=""/>
            <div style="width: 600px;margin:0px;padding:0px;"data-role="navbar"data-theme="d"
                         data-grid="d">
                    <ul style="width: 490px!important;border-color: black!important;" rel="external" data-ajax="false">
                        <li id="redondeado"><a
                                    rel="external" data-ajax="false"  data-theme="c"
                               onclick="fulls_creen2(400,350,3600)" > 1h </a></li>
                        <li><a class="no-redondeado"
                                    rel="external" data-ajax="false" data-theme="c"
                               onclick="fulls_creen2(400,350,43200)" > 12h  </a></li>
                        <li><a class="no-redondeado"
                                    rel="external" data-ajax="false" data-theme="c"
                               onclick="fulls_creen2(400,350,604800)" > 1w  </a></li>
                        <li><a class="no-redondeado"
                                    rel="external" data-ajax="false" data-theme="c"
                               onclick="fulls_creen2(400,350,2592000)" > 1m  </a</li>
                        <li><a class="no-redondeado"
                                    rel="external" data-ajax="false" data-theme="c"
                               onclick="fulls_creen2(400,350,15595200)" > 6m  </a></li>
                    </ul>
            </div>
            </center>
    </div>





</div>





 <?php
} else {
     require_once("errorSession.php");
}
php?>

</body>
</html>
