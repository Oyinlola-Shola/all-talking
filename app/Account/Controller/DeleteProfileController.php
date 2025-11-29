<?php
namespace Talking\NewdichApp\Account\Controller;
use NewdichApp\DTO\DeleteProfiletDTO;
use NewdichApp\Middleware\DeleteProfileMid;

$getData = json_decode(file_get_contents("php:input"), true);

$dto = new DeleteProfiletDTO($getData);
$mid = new DeleteProfileMid();
$logic = new DeleteProfile($dto, $mid);
$logic -> deleteProfile();

?>