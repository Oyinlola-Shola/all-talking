<?php
namespace NewdichApp\Middleware;

class RegMid{
    public function claenData($data){
        return htmlspecialchars(trim($data));
    }

    public function verfiyPwd($pwd){
        if(strlen($pwd) >= 6){
            $hash=password_hash($pwd);
            return $hash;
        }
        else{
            return json_encode(array("status"=>"fail", "response"=>"password must be aleast 6 or more characters"), JSON_PRETTY_PRINT);
        }
    }

    public function genUserName($email){
        $exemail = substr($email,0,6);
        $hashemail = crc32($email);
        $exhashemail = substr($hashemail, 5,9);
        $user_name = $exemail.$exhashemail;
        return $user_name;
    }
}
?>
   