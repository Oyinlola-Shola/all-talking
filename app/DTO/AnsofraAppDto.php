<?php
namespace NewdichApp\DTO;

class AnsofraAppDto{
    public $users_id;
    public $email;
    public $fullname;
    public $password;
    public $country;
    public $region;
    public $city;
    public $address;
    public $zip_code;
    public $phone;
    public $date_created; 
    public $last_seen;
    public $picture;
    public $username;
    public $account_type;
    public $nin;
    public $bvn;
    public $tax_id;
    public $role;

    public function __construct(array $inData){
        $allProp = get_object_vars($this);
        foreach($allProp as $k => $v){
            $this->$k = isset($inData[$k]) ? $inData[$k] : '';
        }
    }
}
?>