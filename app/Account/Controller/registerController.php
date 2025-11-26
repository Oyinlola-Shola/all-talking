<?php
namespace NewdichApp\Account\Controller;

use NewdichApp\DTO\RegDTO;
use NewdichApp\Middleware\RegMid;
$getComingData = json_decode(file_get_contents("php:input"), true);
$dto = new RegDTO($getComingData);
$mid = new RegMid();
$acc = new Register($dto, $mid);
?>