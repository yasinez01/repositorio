<?php
    require 'Consulta.php';
    $seccion = $_POST["seccion"];
    if($seccion=="rutaIda"){
        $numero = $_POST["numero"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numero.'/route/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('ruta_'.$numero.'_Ida.csv', 'w');
        fputcsv($csv_file, array( 'Nombre Parada', 'Numero Parada','Latitud', 'Longitud'));
        $data = $datos->{'data'}->{'stops'}->{'toB'}->{'features'};
        for($i=0;$i<sizeof($data);$i++){
            fputcsv($csv_file, array($data[$i]->{'properties'}->{'stopName'}, $data[$i]->{'properties'}->{'stopNum'}, $data[$i]->{'geometry'}->{'coordinates'}[0], $data[$i]->{'geometry'}->{'coordinates'}[1]));
        }
    }else if($seccion =="rutaVuelta"){
        $numero = $_POST["numero"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numero.'/route/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('ruta_'.$numero.'_Vuelta.csv', 'w');
        fputcsv($csv_file, array( 'Nombre Parada', 'Numero Parada','Latitud', 'Longitud'));
        $data = $datos->{'data'}->{'stops'}->{'toA'}->{'features'};
        for($i=0;$i<sizeof($data);$i++){
            fputcsv($csv_file, array($data[$i]->{'properties'}->{'stopName'}, $data[$i]->{'properties'}->{'stopNum'}, $data[$i]->{'geometry'}->{'coordinates'}[0], $data[$i]->{'geometry'}->{'coordinates'}[1]));
        }
    }else if($seccion == "paradasalrededorconnumero"){
        $numeroparada = $_POST["numeroparada"];
        $metros = $_POST["metros"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundstop/'.$numeroparada.'/'.$metros.'/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('paradanumero_'.$numeroparada.'_con_'.$metros.'_metros.csv', 'w');
        fputcsv($csv_file, array( 'Id Parada','Nombre', 'Latitud','Longitud', 'Dirección','Linea/as'));
        $data = $datos->{'data'};
        for($i=0;$i<sizeof($data);$i++){
            $lineas="";
            for($j=0;$j<sizeof($data[$i]->{'lines'});$j++){
                $lineas .= $data[$i]->{'lines'}[$j]->{"line"};
                if($j < sizeof($datos->{'data'}[$i]->{'lines'}) - 1){
                    $lineas .= ", ";
                }
            }
            fputcsv($csv_file, array($data[$i]->{'stopId'}, $data[$i]->{'stopName'}, $data[$i]->{'geometry'}->{"coordinates"}[0], $data[$i]->{'geometry'}->{'coordinates'}[1],$data[$i]->{'address'},$lineas));
        }
    }else if($seccion == "paradasalrededorconlongitudylatitud"){
        $longitud=$_POST["longitud"];
        $latitud=$_POST["latitud"];
        $radio=$_POST["radio"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundxy/'. $longitud.'/'. $latitud .'/'.$radio.'/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('parada_longitud_'.$longitud.'_latitud_'.$latitud.'_metros-'.$radio.'.csv', 'w');
        fputcsv($csv_file, array( 'Id Parada','Nombre', 'Latitud','Longitud', 'Dirección','Linea/as'));
        $data = $datos->{'data'};
        for($i=0;$i<sizeof($data);$i++){
            $lineas="";
            for($j=0;$j<sizeof($data[$i]->{'lines'});$j++){
                $lineas .= $data[$i]->{'lines'}[$j]->{"line"};
                if($j < sizeof($datos->{'data'}[$i]->{'lines'}) - 1){
                    $lineas .= ", ";
                }
            }
            fputcsv($csv_file, array($data[$i]->{'stopId'}, $data[$i]->{'stopName'}, $data[$i]->{'geometry'}->{"coordinates"}[0], $data[$i]->{'geometry'}->{'coordinates'}[1],$data[$i]->{'address'},$lineas));
        }
    }else if($seccion== "calendario"){
        $fechaini=$_POST["fechaini"];
        $fechafin=$_POST["fechafin"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/calendar/'.str_replace("-","",$fechaini).'/'.str_replace("-","",$fechafin).'/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('calendario_fechaini_'.$fechafin.'_fechafin_'.$fechafin.'.csv', 'w');
        fputcsv($csv_file, array( 'Fecha','¿HUELGA?', 'TIPO DE DÍA'));
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            $dia= explode(" ",$datos->{'data'}[$i]->{'date'});
            $huelga="Sí";
            $tipodia="Día festivo";
            if($datos->{'data'}[$i]->{'strike'} == "N")  $huelga="No";
            if($datos->{'data'}[$i]->{'dayType'}=="LA")  $tipodia="Día laborable";
            elseif($datos->{'data'}[$i]->{'dayType'}=="SA") $tipodia= "Sábado";
            fputcsv($csv_file, array($dia[0],$huelga, $tipodia));
        }
    }else if($seccion == "informacionlineas"){
        $fecha = $_POST["fecha"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/'.$fecha.'/';
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('informacion_todas_lineas_fecha_'.$fecha.'.csv', 'w');
        fputcsv($csv_file, array( 'Linea','Grupo'));
        for($i=0; $i<sizeof($datos->{'data'}); $i++){
            fputcsv($csv_file, array($datos->{'data'}[$i]->{'startDate'},$datos->{'data'}[$i]->{'group'}));
        }
    }else if($seccion == "informacionlinea"){
        $numerolinea = $_GET["linea"];
        $fecha=$_GET["fecha"];
        $Consulta = new Consulta();
        $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numerolinea.'/info/'.str_replace("-","",$fecha1).'/';  
        $respuesta=$Consulta->realizarconsulta($url,'GET');
        $datos = json_decode($respuesta);
        $csv_file = fopen('informacion_todas_linea_'.$numerolinea.'_fecha_'.$fecha.'.csv', 'w');
        fputcsv($csv_file, array( 'Linea','Desde,Hasta,Tipo día,Hora Inicio 1,Hora fin 1, Minima frecuencia espera min 1 , Maxima frencuencia espera min 1,Hora Inicio 2,Hora fin 2, Minima frecuencia espera min 2, Maxima frencuencia espera min 2'));
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            $data = $datos->{'data'}[$i];
            for($j=0; $j<sizeof($datos->{'data'}[$i]->{'timeTable'}); $j++){
                $dia="Día festivo";
                if($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="LA") $dia="Día laborable";
                elseif($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="SA") $dia="Sábado";
                fputcsv($csv_file, array($data->{'line'},$data->{'nameA'},$data->{'nameB'},$dia,$data->{'timeTable'}[$j]->{'Direction1'}->{'StartTime'},$data->{'timeTable'}[$j]->{'Direction1'}->{'StopTime'},$data->{'timeTable'}[$j]->{'Direction1'}->{'MinimunFrequency'},$data->{'timeTable'}[$j]->{'Direction1'}->{'MaximumFrequency'},$data->{'timeTable'}[$j]->{'Direction2'}->{'StartTime'},$data->{'timeTable'}[$j]->{'Direction2'}->{'StopTime'},$data->{'timeTable'}[$j]->{'Direction2'}->{'MinimunFrequency'},$data->{'timeTable'}[$j]->{'Direction2'}->{'MaximumFrequency'}));
            }
        }
    }
    fclose($csv_file);
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>