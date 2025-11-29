<?php
namespace Talking\NewdichApp\DTO;

class EditProfileDTO{
    public $file;
    public $phone_number;
    public function __construct(array $dataIn){
        $getDataArr = get_object_vars($this);
        foreach($getDataArr as $key=>$val){
            $this->$key=isset($dataIn[$key]) ? $dataIn[$key]:'';
        }
    }
}