<?php

namespace App\Service;

use App\Models\Person;


class UserService
{
    public function getAllPeople($perPage)
    {
        return Person::paginate($perPage);
    }

    public function updateUser($id, array $data)
    {
        $user = Person::find($id);
        $user->update($data);
        return $user->fresh(); 
    }

}
