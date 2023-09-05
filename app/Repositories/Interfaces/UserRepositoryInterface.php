<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{

    public function getAllUser();
    public function getUserId($userId);
    public function deleteUser($userId);
    public function createUser(array $userDetails);
    public function updateUser($userId, array $userDetails);
    public function storeOrUpdate($id = null,array $userDetails);
}







