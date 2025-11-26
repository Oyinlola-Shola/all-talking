<?php
namespace NewdichApp\Account\Controller;
use NewdichApp\DTO\GetContactDTO;
use NewdichApp\Middleware\GetContacMid;

$getComeingData  = json_decode(file_get_contents("php:input"), true);
$dto = new GetContactDTO($getComeingData);
$mid = new GetContacMid();
// $acc = new GetContact($dto, $mid);
?>