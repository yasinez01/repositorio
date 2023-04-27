<?php
    session_start();
    class Consulta{
        function realizarconsulta($url,$customrequest){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $customrequest,
                CURLOPT_HTTPHEADER => array(
                    'accessToken: '. $_SESSION['accessToken'],
                    'Cookie: SERVERIDP=b45a524a27860afec772689f834014cb22bcb504'
                    ),
                ));
                     
                $response = curl_exec($curl);
                curl_close($curl);
                return $response;
        }

    }