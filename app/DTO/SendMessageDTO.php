<?php
namespace NewdichApp\DTO;

class SendMessageDTO{
    public $sender_phone_number;
    public $receiver_Phone_number;
    public $message;

    public function __construct(array $dataIn){
        $getData = get_object_vars($this);
        foreach($getData as $key => $val){
            $this->$key=isset($dataIn[$key]) ? $dataIn[$key] :'';
        }
    }
} 
?>