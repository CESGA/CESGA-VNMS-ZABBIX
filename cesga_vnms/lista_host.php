<?php
    session_start();
    require_once("cabecera.php");
    //require_once("ZabbixAPI.class.php");
    require_once("funcionsSeguridade.php");
    require_once("funcionsWEB.php");
    // every X hosts
    $num = 10;

    $host_list = array();
    if (!is_null($_SESSION['ListaCompleta'])){
        $i = 0;
        $cont = 0;
        $host_list = array();
        while (($host_list[$i] =  array_slice($_SESSION['ListaCompleta'],$cont,$num))!=null){
            $i++;
            $cont = $cont + $num;
        }


    }
    $totalHOST = $_SESSION['ListaCompleta'];
if (!is_null($_SESSION['datoUsuario'])&&(comproba_session()==TRUE)) {

php?>

<body>
<!-- MENU -->
<div data-role="page" data-theme="b" id="home" >
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

    <div data-role="content" id="content" name="main" data-theme="b">
            <h4 id="tituloSeccion">  Monitoring </h4>
           
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="controlador.php?screens=1" rel="external"
                       data-transition="slide">
                        <img class="ui-li-icon" src="img/1320227717_graph.png" />
                        Screens
                    </a>
                </li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="#search" data-transition="slide">
                        <img class="ui-li-icon" src="img/1319531180_Search.png" />
                        Search host
                    </a>
                </li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="controlador.php?nuevaBusq=1#allhost0" data-transition="slide">
                        <img  class="ui-li-icon" src="img/1319530398_network-transmit-receive.png" />
                        View all host
                    </a>
                </li>
            </ul>


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


<!-- SEARCH -->
<div data-role="page" data-theme="b" id="search" >
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
         <form name="busq" >
           <h4 id="tituloSeccion">  Search Host</h4>

           <ul data-inset="true" data-role="listview" data-theme="c">
               <li data-role="fieldcontain">

               <center>
                   <input type="search" id="campo3B" name="campoBusqHost" value=""
                           placeholder="Search by host name"/>
               </center>
               </li>
               <li data-role="fieldcontain">

               <center>
                   <input type="search" id="campo4B" name="campoBusqGrupo" value=""
                           placeholder="Search by group name"/>
               </center>
               </li> 

               <li data-role="fieldcontain">
                   <input type="hidden" id="sub" name="sub" value="1"/>
                   <input type="hidden" id="select" name="select" value="0"/>
                   <input type="hidden" id="nuevaBusq" name="nuevaBusq" value="1"/>
                   <input type="hidden" id="grupoactivo" name="grupoactivo" value="0"/>
               <center>
                   <select id="campo1B" onchange="buscaHost()" name="campoBusqHost2">
                      <?php
                          if (is_null($_SESSION['campoBusqHost'])||
                                  ($_SESSION['campoBusqHost']=="")){
                              echo '<option value=""> any Host </option> ';
                          }

                          foreach ($totalHOST as $totalh){
                             $cadena = '<option value="'.$totalh[host].'" ';
                                if (!is_null($_SESSION['campoBusqHost'])&&
                                        ($_SESSION['campoBusqHost']==$totalh[host])){
                                    $cadena = $cadena. ' selected';
                                }
                              echo $cadena. ' >'.$totalh[host].
                                '</option>';

                          }
                          if (!is_null($_SESSION['campoBusqHost'])&&
                                  ($_SESSION['campoBusqHost']!="")){
                              echo '<option value=""> any Host </option> ';
                          }
                      php?>
                       </select>
               </center>
               </li>
               <li data-role="fieldcontain">
                    <center>
                       <select id="campo2B" onchange="buscaGrupo()"
                               name="campoBusqGrupo2" >
                      <?php
                          if (is_null($_SESSION['campoBusqGrupo'])||
                                  ($_SESSION['campoBusqGrupo']=="")){
                              echo '<option value=""> any Group </option> ';
                          }
                          foreach ($_SESSION['ListaGrupos']  as $grupo){
                             $cadena = '<option value="'.$grupo[name].'" ';
                                if (!is_null($_SESSION['campoBusqGrupo'])&&
                                        ($grupo[name]==$_SESSION['campoBusqGrupo']))
                                    {
                                    $cadena = $cadena. ' selected';
                                }
                              echo $cadena. ' >'.$grupo[name].' </option>';

                          }
                          if (!is_null($_SESSION['campoBusqGrupo'])&&
                                  ($_SESSION['campoBusqGrupo']!="")){
                              echo '<option value=""> any Group </option> ';
                          }
                      php?>
                       </select>
                   </center>
               </li>
           </ul>


           <a href="#"  data-role="button" data-transition="slide"
              onclick="buscando()"  onKeyPress="buscando()" data-theme="a">Search</a>

            <!--<button data-theme="a" type="submit" name="Submit" value="Submit"
              class="mySubmitButtonClass">Search</button> -->
        </form>
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

 <?php
 $indice =0;


 foreach($host_list as $hosts){
  
     php?>
<!-- ALL HOST -->
<div data-role="page" data-theme="b" id="allhost<?php echo $indice; php?>" >
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



    <div data-role="content" id="content" name="main">
       <?php
          if (count($hosts)>0){

            if (!is_null($_SESSION[vacio])){
                php?>
                   <center>
                        <ul data-role="listview" data-inset="true" data-theme="c">
                            <li><a href="controlador.php?lista_host.php#search" data-transition="slide">Click here to search again</a></li>
                        </ul>
                       <h4 id="tituloSeccion">  Hosts </h4>
                       <img src="img/1318575694_alert.png" alt="Error"/>
                       <p> Your host search not found </p>

                   </center>
                <?php
            } else {
       php?>

            <ul data-role="listview" data-inset="true" data-theme="c">
              <li><a href="controlador.php?lista_host.php#search" data-transition="slide">Click here to search again</a></li>
            </ul>
            <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
       <?php
            $cont = 0;
            foreach ($hosts as $host){  php?>
          <?php if ($grupoAnterior != $host[name] || ($cont==0)) { php?>
                <li data-role="list-divider"role="heading">
                        <?php echo $host[name]; php?>
                </li>
          <?php } php?>
                <li><a style="white-space:normal!important;"
                       data-ajax="false" href="controlador.php?<?php echo "idhost=".$host[hostid].
                   "&host=".$host[host]."&ip=".$host[ip]."&grupo=".$host[name].
                   "&numero=".$_GET['numeroA']; php?>">
                                <?php echo $host[host]." : ".$host[ip]; php?>
                   </a>
               </li>

        <?php
                $cont++;
                $grupoAnterior = $host[name];
          } php?>
            </ul>

            


<?php  $contador=0; php?>
   <div data-theme="a" data-type="horizontal" data-role="controlgroup">

<?php //foreach($host_list as $nhost){
        if ($indice==0&&$host_list[0][0]!=""){ php?>
          <a href="#allhost0" data-theme="a" data-role="button">0</a>
          <?php if (!is_null($host_list[1])&&count($host_list[1])>0){ php?>
          <a href="#allhost1" data-theme="a" data-role="button">1</a>
          <?php }
                if (!is_null($host_list[2])&&count($host_list[2])>0){ php?>
          <a href="#allhost2" data-theme="a" data-role="button">2</a>
          <?php }
                if (count($host_list)==3&&count($host_list[2])>0){ php?>
          <a href="#allhost3" data-theme="a" data-role="button">3</a>
          <?php }
                else if (count($host_list)>4) { php?>
          <a href="#allhost3" data-theme="a" data-role="button">></a>
          <?php } php?>

<?php   } else if (($indice>0)&&(!is_null($host_list[$indice+3]))){
             echo '<a href="#allhost'.
                        ($indice-1) .'" data-theme="a" data-role="button"><</a> ';
            for ($i=$indice;$i<$indice+2;$i++){
                echo '<a href="#allhost'.$i.'" data-theme="a" data-role="button">'.
                        $i.'</a> ';
            }
             echo '<a href="#allhost'.($indice+2) .'" data-theme="a" data-role="button">></a> ';
        } else if (($indice>0)&&(is_null($host_list[$indice+3]))) {
             echo '<a href="#allhost'.
                        ($indice-1) .'" data-theme="a" data-role="button"><</a> ';

                $i=$indice;
            while (!is_null($host_list[$i])){
                if (count($host_list[$i])>0){
                echo '<a href="#allhost'.
                        $i .'" data-theme="a" data-role="button">'.
                        $i.'</a> ';
                }
                $i++;
            }

        } else {    php?>

          <a href="#allhost0" data-theme="a" data-role="button">0</a>
<?php
        }
php?>
      </div>
<?php
    }
  } else { php?>

                   <center>
                       <h4 id="tituloSeccion">  Hosts </h4>
                       <img src="img/1318575694_alert.png" alt="Error"/>
                       <p> You haven't any host </p>

                   </center>
        
  <?php } php?>
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
 <?php
    $indice++; php?>
</div>
<?php


 }
 php?>





 <?php
} else {
     require_once("errorSession.php");
} php?>

    </body>

</html>
