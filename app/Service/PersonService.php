<?php

namespace App\Service;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendBatchEmailJob;
use App\Helpers\CommandResponse;
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

    public function getPerson($id)
    {
        return Person::find($id);
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

    public function deactivateUserById($id)
    {
        return User::find($id)->update(['status' => User::STATUS_DEACTIVE]);
    }

    public function activateUserById($id)
    {
        return User::find($id)->update(['status' => User::STATUS_ACTIVE]);
    }

    public function deActivateAllUsers()
    {
        return DB::table('users')
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_USER)
            ->update(['status' => User::STATUS_DEACTIVE]);
    }

    public function activateAllUsers()
    {
        DB::table('users')
            ->where('status', User::STATUS_DEACTIVE)
            ->where('role', User::ROLE_USER)
            ->update(['status' => User::STATUS_ACTIVE]);
    }    

    public function sendBatchEmailsToPeople()
    {
        $query = User::query()->where('status', User::STATUS_ACTIVE);
        $totalPeople = $query->count();
        if ($totalPeople === 0) {
            return CommandResponse::error('No active users (status = 1) to send email');
        }

        $batchCount = 0;
        $query->latest('id')
            ->select('id', 'email')
            ->chunk(10, function($users) use (&$batchCount) { 
                $batchCount++;
                $userIds = $users->pluck('id')->all();
                SendBatchEmailJob::dispatch($batchCount, $userIds);
            });

        return CommandResponse::success("Scheduled email sending for {$totalPeople} users (status = 1) in {$batchCount} batches");
    }
    
}
