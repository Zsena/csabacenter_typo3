<?php

$token = $_GET['token'];
$url = base64_decode($token);

$client = new GuzzleHttp\Client();
$response = $client->get($url);

header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: application/json; charset=utf-8');
header('Content-Transfer-Encoding: 8bit');

echo $response->getStatusCode() == 200 ? $response->getBody() : '{}';
