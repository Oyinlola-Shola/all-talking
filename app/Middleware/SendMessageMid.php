<?php
namespace NewdichApp\Middleware;

class SendMessageMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}