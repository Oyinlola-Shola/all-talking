<?php
namespace Talking\NewdichApp\Account\Controller;
use Talking\NewdichApp\DTO\UpdateAccountDTO;
use Talking\NewdichApp\Middleware\UpdateAccountMid;

$getData = json_decode(file_get_contents("php:input"), true);

$dto = new UpdateAccountDTO($getData);
$mid = new UpdateAccountMid();

$logic = new UpdateAccount($dto, $mid);
$logic ->updateAccount();

?>