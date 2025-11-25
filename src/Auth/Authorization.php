<?php
namespace NewdichSrc\Auth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authorization{
    private $userToken;
    private $user_id;
    private $role;
    private $expirationDate;
    private $authResponse;

    public function __construct($userToken){
        try{
            $this->userToken = $userToken;
            $decodeToken = JWT::decode($this->userToken, new Key(Settings::AUTH_KEY, 'HS256'), ['exp' => false]);
            $this->user_id = $decodeToken->user_id;
            $this->role = $decodeToken->role;
            //$this->expirationDate = $decodeToken->exp;
            $this->authResponse = json_encode(array("status"=>"success", "response"=>"successfully authorized"), JSON_PRETTY_PRINT);
        }
        catch(ExpiredException $e){
            $this->authResponse = json_encode(array("status"=>"failed", "response"=>"Authorization token has expired, please relogin"), JSON_PRETTY_PRINT);
        }
        catch(Exception $e){
            $this->authResponse = json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }

    public function process(){
        return $this->authResponse;
    }

}
?>