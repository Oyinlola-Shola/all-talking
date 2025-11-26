<?php
namespace NewdichApp\DTO;

class RegDTO{
    public $name;
    public $email;
    public $phone_number;
    public $password;

    public function __construct(array $dataIn){
        $getData = get_object_vars($this);
        foreach($getData as $key=>$val){
            $this->$key=isset($dataIn[$key])?$dataIn[$key]:'';
        }
    }
}
?>