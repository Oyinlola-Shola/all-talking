<?php
namespace NewdichSrc\Middleware;

class Newdich{
    public function cleanData($data){
        $data = htmlspecialchars(trim($data));
        return $data;
    }

    public function hashData($data){
        $pwdhash = password_hash($data, PASSWORD_DEFAULT);
        return $pwdhash;
    }

    public function verifyHash($data){
        $hashedData = $this->hashData($data);
        if(password_verify($data, $hashedData)){
            return "success";
        }
        else{
            return "failed";
        }
    }

    public function otp(){
        $nownow = md5(strtotime(date("Y-m-d H:i:s")));
        $otp = crc32($nownow);
        $otp = substr($otp, 0, 5);
        return $otp;
    }


}
?>