<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    $params = array('apiKey' => $_ENV['RANDOMORG_APIKEY'], 'n' => $_GET['n'], 'decimalPlaces' => 4, 'replacement' => false);
    $fields = array('jsonrpc' => '2.0', 'method' => 'generateDecimalFractions', 'params' => $params, 'id' => 1);
    $fields_string = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.random.org/json-rpc/2/invoke');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    return curl_exec($ch);
    curl_close($ch);
