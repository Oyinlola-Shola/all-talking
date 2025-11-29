<?php
namespace NewdichApp\Account\DTO;

class ContactListDTO{
    public $user_name;
    public $user_name_to_add;
    public function __construct(array $dataIN){
        $getData = get_object_vars($this);
        foreach($getData as $val => $key){
            $this->$key=isset($dataIN[$key])?$dataIN[$key]:''; 
        }
    }
}
?>