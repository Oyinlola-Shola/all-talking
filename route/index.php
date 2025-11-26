<?php
namespace NewdichRoute;
//let apis request go to apis controller
//let app request go to app controller
//let src request go to src controler
$url = $_SERVER['URI'];
if($url==='/register'){
    require_once '/app/Account/Controller/registerController.php';
}
elseif($url==='/login'){
    require_once '/app/Account/Controller/loginController.php';
}
elseif($url==='/getContact'){
    require_once '/app/Account/Controller/getContactController.php';
}
elseif($url==='/saveMessage'){
    require_once '/app/Account/Controller/saveMessageController.php';
}
?>