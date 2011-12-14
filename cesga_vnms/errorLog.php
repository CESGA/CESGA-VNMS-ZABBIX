<?php require_once("cabecera.php");
php?>

<body>
<div data-role="page" data-theme="b" id="home" >
    <div data-role="header" id="hdrMain" name="hdrMain"
         data-position="fixed" data-theme="b" data-position="inline" >
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO.png" alt="CESGA VNMS"/> </h2>

    </div>


    <div style="text-align:justify;" data-role="content" id="content" name="main" data-theme="b">
            <h4 id="tituloSeccion">  An error ocurred in your session </h4>

                <ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="b">
                <li data-role="list-divider"role="heading">
                    An error ocurred in your session
                </li>
                <li>
                    <p style="text-align: justify;font-size: 14px;white-space:normal!important;">
            An error ocurred in your session. Click F5 to refresh!<br/>

            Or <a href="controlador.php?logout=1">Click here</a> to go main page, where you can access identify user.
                    </p>
                </li></ul>
    </div>


 </div>
</body>