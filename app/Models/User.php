<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 2.3.18.
 * Time: 20.26
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class User
{
    private $id;
    private $username;
    private $password;
    private $first_name;
    private $last_name;
    private $email;
    private $role;

    public function __construct()
    {

    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getFirstName()
    {
        return $this->first_name;
    }


    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }


    public function getLastName()
    {
        return $this->last_name;
    }


    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getRole()
    {
        return $this->role;
    }


    public function setRole($role)
    {
        $this->role = $role;
    }

    public function insertNewUser(){
        $id = DB::table('Users')
            ->insertGetId(
                [
                    'username' => $this->username,
                    'password' => md5($this->password),
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'role' => 'user'
                ]
            );
        return $id;
    }

    public function loginUser(){
        $res = DB::table('Users')
            ->select('*')
            ->where([
                'username' => $this->username,
                'password' => md5($this->password)
            ])
            ->first();
        return $res;
    }

    public static function checkUsernameAvb($username){
        $res = DB::table('Users')
            ->where('username', $username)
            ->first();
        return $res;
    }



}