<?php

namespace App\Service;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonService
{

    public function paginated($perPage)
    {
        return Person::paginate($perPage);
    }

    public function getAllPeople()
    {
        return Person::all();
    }

    public function createPerson(array $data)
    {
        return Person::create($data);
    }

    public function updatePerson($id, array $data)
    {
        $person = Person::find($id);
        $person->update($data);
        return $person->fresh(); 
    }

    public function deletePerson($id)
    {
        $person = Person::find($id);
        $person->delete();
        return $person; 
    }

    public function store(Request $request)
    {
        return Person::create($request->all());
    }

}
