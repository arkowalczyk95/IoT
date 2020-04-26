<?php

    function api_get_active_mode_params(){
        $url = 'localhost:8080/api';
        $collection_name = 'modes/selected';
        $request_url = $url . '/' . $collection_name;
//        echo $request_url;
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
//        echo $response . PHP_EOL;

        return json_decode($response, true);
    }


    function api_get_mode_params($mode_id){
        $url = 'localhost:8080/api';
        $collection_name = 'modesId/' . $mode_id;
        $request_url = $url . '/' . $collection_name;
//        echo $request_url;
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
//        echo $response . PHP_EOL;

        return json_decode($response, true);
    }

?>
