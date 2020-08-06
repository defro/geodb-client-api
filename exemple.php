<?php

use fGalvao\BaseClientApi\HttpClient;
use fGalvao\GeoDB\GeoDB;
use fGalvao\GeoDB\Resource\City;
use fGalvao\GeoDB\Resource\Country;
use fGalvao\GeoDB\Resource\Region;

require 'vendor/autoload.php';

$config   = include 'config.php';
$settings = [
    'BASE_URL' => $config['BASE_URL'],
    'API_HOST' => $config['API_HOST'],
    'API_KEY'  => $config['API_KEY'],
    'DEV_MODE' => $config['DEV_MODE'],
];

function checkSuccess($resp)
{
    if (!$resp->isSuccess()) {
        var_dump($resp->getBodyData());
        die;
    }
}

$clientSetting = GeoDB::buildClientSettings($config);

$geo = new GeoDB(new HttpClient($clientSetting));

echo '<pre>';
echo '<b>List all countries</b><br/>';
$resp = $geo->countries();
checkSuccess($resp);
/** @var Country[] $countries */
$countries = $resp->getBody();
echo 'Resource object<br/>';
var_dump($countries);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);

echo '<b>Filter countries by prefix "United K" </b><br/>';
$resp = $geo->countries("United K");
checkSuccess($resp);
/** @var Country[] $countries */
$countries = $resp->getBody();
echo 'Resource object<br/>';
var_dump($countries);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);


$uk = reset($countries);
echo '<b>List all regions from uk</b><br>';
$resp = $geo->regions($uk->code);
checkSuccess($resp);
/** @var Region[] $regions */
$regions = $resp->getBody();
echo 'Resource object<br/>';
var_dump($regions);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);

echo '<b>Filter uk regions by prefix engla</b><br>';
$resp = $geo->regions($uk->code, 'engla');
checkSuccess($resp);
/** @var Region[] $regions */
$regions = $resp->getBody();
echo 'Resource object<br/>';
var_dump($regions);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);

$en = reset($regions);
echo '<b>List all cities from England</b><br>';
$resp = $geo->cities($en->countryCode, $en->code);
checkSuccess($resp);
/** @var City[] $regions */
$cities = $resp->getBody();
echo 'Resource object<br/>';
var_dump($cities);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);

echo '<b>Filter England cities by prefix lond</b><br>';
$resp = $geo->cities($en->countryCode, $en->code, 'lond');
checkSuccess($resp);
/** @var City[] $regions */
$cities = $resp->getBody();
echo 'Resource object<br/>';
var_dump($cities);
echo 'Api response<br/>';
var_dump($resp->getResponse());

//Api restriction
sleep(3);

echo '<b>Filter England cities by prefix lond setting the language Spanish</b><br>';
$resp = $geo->cities($en->countryCode, $en->code, 'lond', 'es');
/** @var City[] $regions */
$cities = $resp->getBody();
echo 'Resource object<br/>';
var_dump($cities);
