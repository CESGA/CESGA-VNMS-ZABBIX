<?php
    session_start();
    require_once("cabecera.php");
    //require_once("ZabbixAPI.class.php");
    require_once("funcionsSeguridade.php");
    require_once("funcionsWEB.php");


if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {

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
                   rel="external"  data-ajax="false"   class="ui-btn-right botonLogut">Logout</a>
    </div>

    <div data-role="content" id="content" name="main">

            <h4 id="tituloSeccion">  Tools </h4>
            <ul data-role="listview" data-inset="true" data-theme="c">
                <li>
                    <a href="#networkQuery" data-transition="slide">
                        <img  class="ui-li-icon" src="img/1319537763_Gnome-Preferences-System-Network-64.png" />
                        Network Query Tool 
                    </a>
                </li>
            </ul>
    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          class="">Monitoring</a></li>
                    <li><a id="tools2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="ui-state-persists  activado">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

</div>



<div data-role="page" data-theme="b" id="networkQuery" >
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

  <form method="get" action="<?php echo $_SERVER['PHP_SELF']?>#resultados" rel="external" data-ajax="false">
    <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
        <li data-role="list-divider"role="heading">
           Network query Tool
        </li>
        <li>
            <input type="text" 
                   value="<?php
                     if($_REQUEST['target']!=null ){
                        echo str_replace(" ", "",$_REQUEST['target']);
                     } else { echo ""; }
                    php?>" name="target" data-theme="d" placeholder="ip/host"/>
        </li>
        <li>
            <input type="text" value="80" name="port" data-theme="d" placeholder="port number (Optional)"/>
        </li>
        <li>
    <fieldset data-role="controlgroup">
        <input type="radio" name="queryType" value="all" data-theme="d" id="radio-choice-8" checked="checked" />
     	<label for="radio-choice-8">All</label>

     	<input type="radio" name="queryType" value="lookup" data-theme="d" id="radio-choice-1" />
     	<label for="radio-choice-1">Direct/Reverse DNS resolution </label>

     	<input type="radio" name="queryType" value="dig" data-theme="d" id="radio-choice-2" />
     	<label for="radio-choice-2">DNS records </label>

     	<input type="radio" name="queryType" value="wwwhois" data-theme="d" id="radio-choice-3"/>
     	<label for="radio-choice-3">Whois (Web)</label>

     	<input type="radio" name="queryType" value="arin" data-theme="d" id="radio-choice-4" />
     	<label for="radio-choice-4">Whois (IP)</label>

     	<input type="radio" name="queryType" value="checkp" data-theme="d" id="radio-choice-5"/>
     	<label for="radio-choice-5">Port check</label>

     	<input type="radio" name="queryType" value="p" data-theme="d" id="radio-choice-6" />
     	<label for="radio-choice-6">Ping</label>

     	<input type="radio" name="queryType" value="tr" data-theme="d" id="radio-choice-7" />
     	<label for="radio-choice-7">Traceroute</label>

    </fieldset>
        </li>
         <li>
            <input type="submit" data-ajax="false" rel="external" name="Submit" value="Check" data-theme="a">
        </li>
    </ul>
  </form>
    </div>


    <div data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          class="">Monitoring</a></li>
                    <li><a id="tools2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="ui-state-persists  activado">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
                           >Settings</a></li>
                </ul>
            </div>
    </div>

</div>





<div data-role="page" data-theme="b" id="resultados" >
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
      <ul data-role="listview" data-theme="c" data-inset="true"><li>
        <a href="#networkQuery" data-theme="c"
           data-transition="slide">Click here for new query</a>
      </li></ul>
      <?php
      /* Controller logic begins here. */
      require_once('NetworkQueryTool.php');
      if (!isset($_REQUEST['target']))
          $_REQUEST['target'] = '';
      if ($_REQUEST['target']) {
          php ?>

   <?php
   /* Create NQT object */
    $nqt = new NetworkQueryTool($_REQUEST['target']);

    /* Turn on debug output if requested */
    if ($debug == true) {
        $nqt->enableDebug(true);
    }

    php?>

    <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">

        <?php
    /* Determine which activities to perform */
    if ($_REQUEST['queryType'] == 'lookup' || $_REQUEST['queryType'] == 'all') {

        flush();
        echo '<li data-role="list-divider"role="heading"> Direct/Reverse DNS resolution  </li>';

    if (($resolved = $nqt->doResolveHost()) === false) {
        echo '<li>'.$nqt->getTarget() . ' could not be resolved.</li>';
    } else {

        //$cadena = str_replace(";", "<br/>;", $nqt->doResolveHost());
        $cadena = str_replace("<br/>", "", $nqt->getTarget());
        echo '<li><p style="margin-top:5px!important;white-space:normal!important;">'.
             $nqt->getTarget() . ' resolves to ' . $nqt->doResolveHost().'</p></li>' ;
    }
    }     php?>
        
   <?php
    if ($_REQUEST['queryType'] == 'dig' || $_REQUEST['queryType'] == 'all') {
        flush();
        $cadena = str_replace("\n", "<br/>", $nqt->doDig());
        echo '<li data-role="list-divider"role="heading"> DNS Query Request </li>';
        echo '<li><p style="white-space:normal!important;">'.$cadena.'</p></li>';
    }
    php?>

   <?php
    if ($_REQUEST['queryType'] == 'wwwhois' || $_REQUEST['queryType'] == 'all') {
    $cadena = str_replace("%", "<br/>#", wordwrap($nqt->doWwwWhois(), 100));
    echo '<li  data-role="list-divider"role="heading"> WWWhois Request</li>';
    echo '<li><p style="white-space:normal!important;">'.$cadena.'</p></li>';
    }
    php?>

    <?php
     if ($_REQUEST['queryType'] == 'arin' || $_REQUEST['queryType'] == 'all') {

      $cadena = str_replace(";", " ", $nqt->doRirWhois());
      $cadena = ereg_replace("\n[[:alpha:]]+:", "<br/><b>\\0</b>", $cadena);


      $cadena = str_replace("\n", "<br/>", $cadena);
      $cadena = str_replace("%", "<br/>#", $cadena);
      $cadena = str_replace("&", "&<br/>", $cadena);
      $cadena = str_replace("?showDetails", "?<br/>showDetails", $cadena);
      //$cadena = ereg_replace("?[[:alpha:]]+", "<br/>\\0", $cadena);
      echo '<li  data-role="list-divider"role="heading"> RIR Request </li>';
      echo '<li><p style="white-space:normal!important;">'.$cadena.'</p></li>';
      flush();
    }
    php?>

    <?php
  if ($_REQUEST['queryType'] == 'checkp' || $_REQUEST['queryType'] == 'all') {
    echo '<li  data-role="list-divider"role="heading"> Check port </li>';
    if (preg_match('|[^0-9]|', $_REQUEST['port'])) {
      echo '<li style="font-size:10px!important;"> Invalid port specified. </li>';
    } else {
        $cadena = $nqt->doCheckPort($_REQUEST['port']) ? 'Port ' . $_REQUEST['port'] .
           ' is open ' : '<pre>Port ' . $_REQUEST['port'] . ' is closed</pre>';
      echo '<li style="font-size:10px!important;">'.
            $cadena .'</li>';
    }
    flush();
  }
  php?>

  <?php
    if ($_REQUEST['queryType'] == 'p' || $_REQUEST['queryType'] == 'all') {
    $cadena = str_replace("\n", "<br/>", $nqt->doPing());
        echo '<li  data-role="list-divider"role="heading"> Ping Request </li>';
        echo '<li><p style="white-space:normal!important;">'.$cadena.'</p></li>';
        flush();
    }
    php?>

   <?php
     if ($_REQUEST['queryType'] == 'tr' || $_REQUEST['queryType'] == 'all') {
        $cadena = str_replace("\n", "<br/>", $nqt->doTraceroute());
        echo '<li  data-role="list-divider"role="heading">Traceroute Request</li>';
        echo '<li><p style="white-space:normal!important;">'.$cadena.'</p></li>';
        flush();
    }
    php?>
    </ul>

    <?php  if ( $_REQUEST['queryType'] == 'all') {   php?>

         <ul data-role="listview" data-theme="c" data-inset="true"><li>
            <a href="#networkQuery" data-theme="c" data-transition="slide">Click here for new query</a>
         </li></ul>

    <?php  }   php?>

<?php } else { php?>

                        <center>
                            <br/><br/>
                            <img src="img/1319018484_notification_error.png" alt="error"/>
                            <br/>
                            <p> Error in Network query tool </p>
                        </center>

<?php } php?>

    </div>


    <div  data-position="fixed" data-id="menu1" data-role="footer" data-theme="a">
            <div data-role="navbar" data-theme="a"  role="navigation" class="nav-iconos" data-grid="c">
                <ul>
                    <li><a id="dashboard" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?alerta=1" data-transition="slide" data-ajax="false"
                            class=""> Dashboard
                        </a></li>
                    <li><a id="host" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?nuevaBusq=1" data-transition="slide" data-ajax="false"
                          class="">Monitoring</a></li>
                    <li><a id="tools2" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?tools=1"data-transition="slide"  data-ajax="false"
                           class="ui-state-persists  activado">Tools</a></li>
                    <li><a id="config" data-icon="custom" data-theme="a" data-iconpos="top"
                           href="controlador.php?configuracion=1" data-transition="slide" data-ajax="false"
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