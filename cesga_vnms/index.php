<?php require_once("cabecera.php");
      require_once("funcionsSeguridade.php");

      session_start();
php?>




<?php if (!is_null($_SESSION['datoUsuario'])&&(comproba_session())) {
    header("Location: controlador.php?alerta=1");
} else { php?>
<body>

<div data-role="page" data-theme="b" id="page1" data-position="inline" data-title="Login page" data-theme="b">

	    <div data-role="header" id="hdrMain" name="hdrMain" data-theme="b" data-nobackbtn="true">
	        <h2  style="margin-top:3px!important;
                            margin-bottom: 3px!important;">
                    <img src="img/LOGO5.png" alt="CESGA VNMS"/> </h2>
	    </div>


            <div data-role="content" id="contentMain" name="contentMain" data-theme="b">
                <form method="POST" rel="external" data-ajax="false" action="controlador.php">
                <center>
                <h4 id="tituloSeccion">  LOGIN </h4>
                <ul data-inset="true" data-role="listview">
                    <li data-role="fieldcontain">
                        <center>
                        <input type="text" value="<?php
                                if (!is_null($_GET['user'])){
                                    echo $_GET['user'];
                                }
                               php?>"
                               name="nombreUsuario" placeholder="User"/>
                        </center>
                        <?php if (!is_null($_SESSION['url'])) { php?>
                        <input type="hidden" name ="url" value="<?php echo $_SESSION[url]; php?>" />
                        <?php } php?>
                    </li>
                    <li data-role="fieldcontain">
                        <center>
                        <input id="text-list"  type="password" value="" 
                               name="passUsuario" placeholder="Password" />
                        </center>
                    </li>
                 </ul>
                </center>
                    <p class="msgError">
                    <?php
                    if (!is_null($_GET["codigo"])) {
                        // 0  -- Contraseña incorrecta
                        // -1 -- Nombre de Usuario incorrecto
                        // -2 -- Acceso no autorizado
                        // -3 -- No se ha posido realizar la conexion con el servidor
                        // -4 -- El usuario no tiene permisos para acceder a Zabbix
                        if ($_GET['codigo'] == 1) {
                            echo '* Username field should be:   username@domain';
                        } else if ($_GET['codigo'] == 2) {
                            echo '* Password field can\'t be empty';
                        } else if ($_GET['codigo'] == 0) {
                            echo '* User password is wrong';
                        } else if ($_GET['codigo'] == -1) {
                            echo '* Username is not registered in the directorry';
                        } else if ($_GET['codigo'] == -2) {
                            echo '* The user is not authorized in the directory';
                        } else if ($_GET['codigo'] == -3) {
                            echo '* Problem with server connection';
                        } else if ($_GET['codigo'] == -4) {
                            echo '* User has not permission to access zabbix';
                        } else if ($_GET['codigo'] == -5) {
                            global  $USER_API_ZABBIX;
                            echo '* Your api user $USER_API_ZABBIX is not well configured. Check your config';
                        }
                    }
                    php?>
                    </p>

                <input type="submit" value="Login"
                            data-theme="a">
                
            </form>
            
            </div>
            <!--<div data-role="footer" style="none">
                    <br/>
            </div> -->


</div>
</body>
</html>

<?php } php?>