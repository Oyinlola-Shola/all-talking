<?php
namespace Talking\NewdichApp\Middleware;

class EditProfileMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}
?>