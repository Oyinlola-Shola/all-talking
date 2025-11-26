<?php
namespace NewdichApp\Account\Controller;

use NewdichApp\DTO\LogDTO;
use NewdichApp\Middleware\LogMid;
$getComingData = json_decode(file_get_contents("php:input"), true);

$dto = new LogDTO($getComingData);
$mid = new LogMid();
$acc = new Login($dto, $mid);
?>