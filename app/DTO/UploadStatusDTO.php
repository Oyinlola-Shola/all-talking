<?php
namespace Talking\NewdichApp\DTO;

class UploadStatusDTO{
    public $user_name;
    public $file;
    public $descriptions;

    public function __construct(array $dataIn){
        $getData = get_object_vars($this);
        foreach($getData as $key=>$val){
            $this->$key=isset($dataIn[$key])?$dataIn[$key]:'';
        }
    }
}
?>