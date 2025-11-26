<?php
namespace NewdichApp\Middleware;

class GetContacMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}
?>