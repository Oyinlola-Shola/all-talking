<?php
namespace NewdichApp\DTO;

class SaveMesDTO{
    public $user_name;
    public $receiverUser_name;
    public $receiverPhone_num;
    public $phone_num;
    public $message;

    public function __construct(array $dataIn){
        $getData = get_object_vars($this);
        foreach($getData as $key => $val){
            $this->$key=isset($dataIn[$key]) ? $dataIn[$key] :'';
        }
    }
} 
?>