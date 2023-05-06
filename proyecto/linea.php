<?php
require 'Consulta.php';
error_reporting(0);
session_start();
$curl = curl_init();
$opcion=$_GET["opcion"];
$Consulta = new Consulta();
if(empty($opcion)){
    echo'<script type="text/javascript">
        alert("Selecciona una línea");
        window.location.href="linea.html";
        </script>';
}else{
    $opcion = explode("-", $opcion);
    $numero_de_ruta = str_replace(" ","",$opcion[0]);
    $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numero_de_ruta.'/route/';
}
$respuesta=$Consulta->realizarconsulta($url,'GET');
$datos = json_decode($respuesta);
echo '<link rel="stylesheet" href="linea.css" >';
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
    echo'<script type="text/javascript">
        alert("NO data found, prueba con otros valores");
        window.location.href="calendario.html";
        </script>';
}else{
    echo "<p>Trayecto y horarios: Ida - Vuelta</p>";
    echo "<div id='contenedor'>";
        echo "<div id='deAaB'>";
            echo $datos->{'data'}->{'nameSectionA'}."-".$datos->{'data'}->{'nameSectionB'}."<br>";
            for($i=0;$i<sizeof($datos->{'data'}->{'stops'}->{'toB'}->{'features'});$i++){
                echo "Parada nª".($i+1)." :".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'stopName'}."-".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'stopNum'}."<br>";
                echo"      Distancia :".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'distance'}."<br>";
            }
            echo "</div>";
            echo "<div id='deBaA'>";
            echo $datos->{'data'}->{'nameSectionB'}."-".$datos->{'data'}->{'nameSectionA'}."<br>";
            for($i=0;$i<sizeof($datos->{'data'}->{'stops'}->{'toA'}->{'features'});$i++){
                echo "Parada nª".($i+1)." :".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'stopName'}."-".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'stopNum'}."<br>";
                echo"      Distancia :".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'distance'}."<br>";
            }
        echo "</div>";
    echo "</div><br><br><br>";
    if(isset($_SESSION['usuarioregistrado'])){
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
            
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
            
            <link rel="stylesheet" href="mapa.css">
            <title>Paraderos Ruta</title>
        </head>
        <body>
            <div class="container">
                <form class="paraderos-data my-4">
                    <select class="form-select" name="paraderos" id="paraderos">
                        <option value="none" selected>Selecciona la linea</option>
                        <option value="ruta1"> Ida</option>
                        <option value="ruta2"> Vuelta</option>
                    </select>
                </form>
            </div>
            <div id="maparadas"></div><br><br><br>
            <div id="links">
                <form action="csv.php" method="post" target="_blank">
                    <input type="hidden" name="seccion" value="rutaIda">
                    <input type="hidden" name="numero" value="<?php echo $numero_de_ruta ?>">
                    <input type="submit" value="Click para generar CSV Ida">
                </form>
                <form action="csv.php" method="post" target="_blank">
                    <input type="hidden" name="seccion" value="rutaVuelta">
                    <input type="hidden" name="numero" value="<?php echo $numero_de_ruta ?>">
                    <input type="submit" value="Click para generar CSV Vuelta">
                </form>
            </div>
            <script type="text/javascript">
                const mapa = document.getElementById('maparadas');
                const map = L.map(mapa).setView([40.4165,-3.70256],13);
                const rutaSelector = document.getElementById('paraderos');
                const mapPath=document.getElementsByTagName('path');
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                const getData = async () => {
                    const dataParaderos = <?php echo $respuesta; ?>;
                    const markerOptionsRuta1 =   customizedMarkerStyle('blue');
                    const markerOptionsRuta2 = customizedMarkerStyle('red');
                    paraderostoA = dataParaderos.data.stops.toA.features;
                    paraderostoB= dataParaderos.data.stops.toB.features;
                    function customizedMarkerStyle(fillColor) {
                        return{
                            radius :9,
                            fillColor,
                            color: 'black',
                            weight: 1.2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }
                    }
                    function onEachFeature(feature, layer){
                        if(feature.properties && feature.properties.stopName){
                            layer.bindPopup(feature.properties.stopName)
                        }
                    }

                    function showGeoJSon(ruta,marker){
                        L.geoJSON(ruta,{
                            pointToLayer : function(feature, latlng){
                                return L.circleMarker(latlng, marker);
                            },
                            onEachFeature
                        })
                        .addTo(map)
                    }
                    rutaSelector.addEventListener('change', (e) =>{
                        let rutaMostrada = [];
                        if (e.target.value === 'ruta1'){
                            Array.from(mapPath).forEach(path => path.remove())
                            rutaMostrada = [paraderostoA,markerOptionsRuta1]
                        }else if(e.target.value === 'ruta2'){
                            Array.from(mapPath).forEach(path => path.remove())
                            rutaMostrada = [paraderostoB,markerOptionsRuta2]
                        }else{
                            Array.from(mapPath).forEach(path => path.remove())
                        }
                        const  [linea,markerOptions]=rutaMostrada;
                        showGeoJSon(linea,markerOptions);
                    })
                }
                getData();
            </script>
            <script type="text/javascript">
                function rutaIda(){
                        <?php echo "Hola Mundo!!"?>
                    }
            </script>
        </body>
        </html>
    <?php
    }
    echo"<a href='linea.html' style='text-decoration: none;
        color: blue;
        margin-left: 50%;
        border: solid;
        background: #6cc1e3;'>Volver</a>";
}