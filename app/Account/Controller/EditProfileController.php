<?php
namespace Talking\NewdichApp\Account\Controller;
use NewdichApp\DTO\EditProfiletDTO;
use NewdichApp\Middleware\EditProfileMid;

$getData = json_decode(file_get_contents("php:input"), true);

$dto = new EditProfiletDTO($getData);
$mid = new EditProfileMid();
$logic = new UploadPro($dto, $mid);
$logic -> uploadPro();

?>