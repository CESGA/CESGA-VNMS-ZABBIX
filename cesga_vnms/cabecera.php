

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
       <title> Web Zabbix para móvil - CESGA </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?php if (!is_null($_GET['refresca'])) { php?>
                <meta http-equiv="refresh" content="240;url=./controlador.php?alerta=1"/>
        <?php

        } php?>
        <script type="text/javascript" src="javascript/gestionCapas.js"> </script>
        
        <link rel="stylesheet" type="text/css" href="estilos/estiloWEBJQuery.css" />
        <meta HTTP-EQUIV=”Pragma” CONTENT=”no-cache”/>
        <meta HTTP-EQUIV=”Expires” CONTENT=”-1″/>
        <link rel="stylesheet" href="jquery/jquery.mobile-1.0.min.css" />
	<script type="text/javascript" src="jquery/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="jquery/jquery.mobile-1.0.min.js"></script>

        <!--<link rel="stylesheet" href="jquery/jquery.mobile-1.0rc1.css" /> -->
        
        <!--<link rel="stylesheet" href="jquery/jquery.mobile-1.0rc1.min.css" />-->
        <!--
        <script src="jquery/jquery.mobile-1.0rc1.js" type="text/javascript" ></script>
        -->
        <!--
        <script src="jquery/jquery.mobile-1.0rc1.min.js" type="text/javascript" ></script>
        -->
        <!--<script src="jquery/jquery-1.6.4.js" type="text/javascript" ></script>-->
        <!--<script src="jquery/jquery.mobile.min.js" type="text/javascript" ></script>-->

<!--
        <link rel="stylesheet" href="jquery/jquery.mobile-1.0rc3.min.css" />
        <script src="jquery/jquery-1.6.4.js"></script>
        <script src="jquery/jquery.mobile-1.0rc3.min.js"></script>
-->

    </head>
    <script>
        $(document).bind("mobileinit", function(){
              $.extend(  $.mobile , {
                    autoInitializePage: true,
                    touchOverflowEnabled: true,
                    linkBindingEnabled: true
              });
              $.mobile.allowCrossDomainPages = true;
              $.support.cors = true;
              $.mobile.fixedToolbars.setTouchToggleEnabled(false);

        });
    </script>

<!--
    <style>
    	        .ui-icon-dashboard {
	            background-image: url(img/dashboard.png);
	            background-repeat: no-repeat;

	        }

                .ui-icon-config {
	            background-image: url(img/config.png);
	            background-repeat: no-repeat;
	        }

                .ui-icon-tools {
	            background-image: url(img/tools.png);
	            background-repeat: no-repeat;
	        }

                .ui-icon-host {
	            background-image: url(img/hostinfo.png);
	            background-repeat: no-repeat;
	        }

	        .ui-icon-host, .ui-icon-tools, .ui-icon-config, .ui-icon-dashboard{
	            background-position: 0 50%;
                    height: 50px;
                    width: 50px;
                    margin-left: auto;
                    margin-right: auto;
	        }


    </style>-->



