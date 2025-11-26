<?php
namespace NewdichApp\Middleware;

class LogMid{
    public function cleanData($data){
        return htmlspecialchars(trim($data));
    }
      public function verifyPwd($pwd){
        if(strlen($pwd) >= 6){
            $hash = password_hash($pwd, PASSWORD_BCRYPT);
            return $hash;
        }
        else{
            return json_encode(array("status"=>"fail", "response"=>"password must be aleast 6 or more characters"), JSON_PRETTY_PRINT);
        }          

    }
}