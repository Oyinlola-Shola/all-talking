<?php
namespace Talking\NewdichApp\Account\Controller;

use Talking\NewdichApp\DTO\UploadStatusDTO;
use Talking\NewdichApp\Middleware\UploadStatusMid;
use Talking\NewdichApp\Account\Command;

$getInComingData = json_decode(file_get_contents("php:input"), true);

$dto = new UploadStatusDTO($getInComingData);
$mid = new UploadStatusMid();
$logic = new UploadStatus($dto, $mid);
$logic -> uploadStatus();

?>