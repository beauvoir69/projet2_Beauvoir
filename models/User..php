<?php

class User extends Crud
{
    public function __construct($host, $db, $user, $password)
    {
        parent::__construct($host, $db, $user, $password);
    }

    public function getAllUsers()
    {
        return $this->getAll("user");
    }

    public function getUserById($userId)
    {
        return $this->getById("user", $userId);
    }


    public function getUserByUsername($username)
    {
        return $this->getByOneColumn("user", "username", $username);
    }

    public function getUserByToken($token)
    {
        return $this->getByOneColumn("user", "token", $token);
    }

    public function addUser($userData)
    {
        return $this->add("user", $userData);
    }

    public function updateUserById($userId, $userData)
    {
        $this->updateById("user", $userId, $userData);
    }

    public function deleteUserById($userId)
    {
        return $this->delete("user", $userId);
    }
}