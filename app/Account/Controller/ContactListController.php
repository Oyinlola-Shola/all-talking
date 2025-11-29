<?php
namespace NewdichApp\Account\Controller;

use NewdichApp\Account\DTO\ContactListDTO;
use NewdichApp\Account\Middleware\ContactListMid;
$getComingData = json_decode(file_get_contents("php:input"), true);

$dto = new ContactListDTO($getComingData);
$mid = new ContactListMid();
$fri = new ContactList($dto, $mid);
$fri -> contactList();
?>