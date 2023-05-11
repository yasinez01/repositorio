
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSPORTE MADRID</title>
    <link rel="stylesheet" href="web.css" > 
</head>
<body>
    <div class="enlaces">
        <ul>
            <li>
                <a aria-label="Enlace Twitter EMT. Nueva ventana." href="https://twitter.com/emtmadrid" target="_blank">
                    <span class="noVisible"><img id="twitter" src="img/twitter.png"></span>
                </a>
            </li>
            <li>
                <a aria-label="Enlace Facebook EMT. Nueva ventana." href="https://www.facebook.com/emtmadrid" target="_blank">
                    <span class="noVisible"><img id="facebook" src="img/facebook.png"></span></a>
            </li>
            <li>
                <a aria-label="Enlace blog. Nueva ventana." href="https://blog.emtmadrid.es" target="_blank">
                    <span class="noVisible"><img id="blog" src="img/blog.png"></span></a>
            </li>
            <li>
                <a aria-label="Enlace rss EMT. Nueva ventana." href="https://feeds.feedburner.com/emtmadrid" target="_blank">
                    <span class="noVisible"><img id="rss" src="img/rss.png"></span></a>
            </li>
            
            <li>
                <a aria-label="Enlace Instagram. Nueva ventana." href="https://www.instagram.com/emtmadrid" target="_blank">
                <span class="noVisible"><img id="instagram" src="img/instagram.png"></span></a>
            </li>
            <li id="login">
                 <?php
                if(isset($_SESSION['usuarioregistrado'])){
                    echo "<a id='usuarioregistrado'>".$_SESSION['nombreusuario']."</a><br><br>";
                    echo "<a href='cerrarsession.php' id='session'>Cerrar Sessión</a>";
                }else{
                    echo "<img id='imagensession' src='img/login.png'><br>";
                    echo "<a href='loginregister.html' id='session'>Iniciar sesión</a>";
                }
                ?>
            </li>
        </ul>
   </div>
    <header>
        <img id="cabeceraEMTMadrid" src="img/icono.png" width="100" height="100"></img>
        <div class="Funcionalidades">
            <a href="paradasalrededor.html" target="iframe" id="paradas">Paradas Alrededor</a>
            <a href="calendario.html" target="iframe" id="calendario">Calendario</a>
            <a href="lineainformacion.html" target="iframe" id="linea">Informacion De Línea</a>
            <a href="linea.html" target="iframe" id="trayecto">Trayecto</a>

        </div>
    </header>
    <div >
        <iframe name="iframe" id="iframe" src="imagen.html"></iframe>
    </div> 
</body>
</html>