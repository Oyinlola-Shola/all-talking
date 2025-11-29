<?php
namespace NewdichApp\Middleware;

class AddFriendMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}
?>