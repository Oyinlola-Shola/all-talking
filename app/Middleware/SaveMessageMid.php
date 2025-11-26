<?php
namespace NewdichApp\Middleware;

class SaveMessageMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}