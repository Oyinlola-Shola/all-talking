<?php
namespace NewdichApp\DTO;

class LogDTO{
    public $password;
    public $number;

    public function __construct(array $dataIn){
        $getDataAround = get_object_vars($this);
        foreach($getDataAround as $key=>$val){
            $this->$key=isset($dataIn[$key])?$dataIn[$key]:'';
        }
    }
}