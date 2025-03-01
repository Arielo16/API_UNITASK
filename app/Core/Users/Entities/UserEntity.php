<?php

namespace App\Core\Users\Entities;

use Exception;

class UserEntity
{
    public $id;
    public $name;
    public $username;
    public $email;
    public $password;
    public $api_token;

    public function __construct($id, $name, $username, $email, $password, $api_token)
    {
        if (empty($id) || empty($name) || empty($username) || empty($email) || empty($password)) {
            throw new Exception('Invalid UserEntity data');
        }

        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->api_token = $api_token;
    }
}
