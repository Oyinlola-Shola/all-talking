<?php
namespace NewdichSrc\Auth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

 class Authenticate{
    private $userId;
    private $role;

    public function __construct($userId, $role){
        $this->userId = $userId;
        $this->role = $role;
    }

    public function process(){
        try{
            $authPayload = [
                'iss'=>Settings::DOMAIN_NAME, //issuer e.g your domain
                'aud'=>Settings::DOMAIN_NAME, //audience e.g your domain
                'iat'=>time(),
                //'exp'=>time() + (24 * 60 * 60),
                'user_id'=>$this->userId, //can be user id or email
                'role'=>$this->role //role of the user
            ];
    
            $authhash = JWT::encode($authPayload, Settings::AUTH_KEY, 'HS256'); //$jwtSecret is in the table file
            return json_encode(array("status"=>"failed", "response"=>$authhash), JSON_PRETTY_PRINT);
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }
 }
?>