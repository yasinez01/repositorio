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
        function crearAccessToken(){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL =>'https://openapi.emtmadrid.es/v1/mobilitylabs/user/login/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'email: yasinezziani@gmail.com',
                'password: @2001yasinA',
                'Cookie: SERVERIDP=71c191fa49acbbd36b480b3d575968dd658b92cf'
            ),
            ));
            $response = curl_exec($curl);
            $losdatos=json_decode($response);
            $accessToken=$losdatos->{'data'}[0]->{'accessToken'}; 
            $_SESSION['accessToken']= $accessToken; 
            $_SESSion['logeado']=false;
            echo'<script type="text/javascript">
                alert("El accessToken es :'.$accessToken.' !!");
                    window.location.href="web.php";
                    </script>'; 
        }
    }