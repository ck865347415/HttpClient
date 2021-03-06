<?php
/**
 * Created by PhpStorm.
 * User: aiChenK
 * Date: 2019-10-17
 * Time: 10:41
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use HttpClient\HttpClient;


try {
    $client = new HttpClient('http://test.aichenk.com');
    $response = $client->post('/http/uploadFile.php', ['file' => new \CURLFile('./test.log')]);

    if (!$response->isSuccess()) {
        //do something
        //throw new \Exception('request error');
    }
//    echo $response->getBody();
    print_r($response->getJsonBody());
} catch (\Throwable $e) {
    echo 'Exception:' . $e->getMessage();
}

