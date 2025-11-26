<?php
namespace NewdichApp\DTO;

class GetContactDTO{
    public $user_name_Search;

    public function __construct(array $dataIn){
        $getData = get_object_vars($this);
        foreach($getData as $key=>$val){
            $this->$key=isset($dataIn[$key]) ? $dataIn[$key] :'';
        }
    }
}