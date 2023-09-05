<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Auth;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUser()
    {
        $loign_id = Auth::id();
        return User::where('id','!=', $loign_id)->where('type','!=','admin')->get();
    }

     public function storeOrUpdate($id = null,$userDetails)
    {
        if(is_null($id)){
            return User::create($userDetails);
        }else{
           return User::whereId($id)->update($userDetails);
        }
    }

    public function getUserId($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        return User::destroy($userId);
    }


    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails)
    {
        return User::whereId($userId)->update($newDetails);
    }



}
