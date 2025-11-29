<?php
namespace Talking\NewdichApp\Middleware;

class UploadStatusMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
}
?>