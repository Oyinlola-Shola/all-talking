<?php
namespace NewdichApp\Account\Controller;

use NewdichApp\Account\DTO\AddFriendDTO;
use NewdichApp\Account\Middleware\AddFriendMid;
$getComingData = json_decode(file_get_contents("php:input"), true);

$dto = new AddFriendDTO($getComingData);
$mid = new AddFriendMid();
$fri = new AddFriend($dto, $mid);
$fir -> addFriend();