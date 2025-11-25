<?php
namespace NewdichSchema;

class Platform{
    public const USERS ="users_text";
    public const USERS_COLUMNS =[
        'users_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'email VARCHAR(255) NOT NULL',
        'fullname VARCHAR(255) NOT NULL',
        'password VARCHAR(255) NOT NULL',
        'country VARCHAR(255) NOT NULL',
        'region VARCHAR(255) NOT NULL',
        'city VARCHAR(255) NOT NULL',
        'address VARCHAR(255) NOT NULL',
        'zip_code VARCHAR(255) NOT NULL',
        'phone VARCHAR(255) NOT NULL',
        'date_created VARCHAR(255) NOT NULL', 
        'last_seen VARCHAR(255) NOT NULL',
        'picture TEXT',
        'username VARCHAR(255) NOT NULL',
        'account_type VARCHAR(255) NOT NULL',
        'nin VARCHAR(255) NOT NULL',
        'bvn VARCHAR(255) NOT NULL',
        'tax_id VARCHAR(255) NOT NULL'
    ];

    public const ADMINS ="admins_text";
    public const ADMINS_COLUMNS =[
        'admins_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'email VARCHAR(255) NOT NULL',
        'fullname VARCHAR(255) NOT NULL',
        'password VARCHAR(255) NOT NULL',
        'country VARCHAR(255) NOT NULL',
        'region VARCHAR(255) NOT NULL',
        'city VARCHAR(255) NOT NULL',
        'address VARCHAR(255) NOT NULL',
        'zip_code VARCHAR(255) NOT NULL',
        'phone VARCHAR(255) NOT NULL',
        'date_created VARCHAR(255) NOT NULL', 
        'last_seen VARCHAR(255) NOT NULL',
        'picture TEXT',
        'username VARCHAR(255) NOT NULL',
        'role VARCHAR(255) NOT NULL'
    ];

    //you can have as many tables as you want
}
?>