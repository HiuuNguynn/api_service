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

    public function getPersonWithPosts($id)
    {
        return Person::with('posts')->find($id);
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
        return User::userRole()
            ->where('id', $id)
            ->update(['status' => User::STATUS_DEACTIVE]);
    }

    public function activateUserById($id)
    {
        return User::userRole()
            ->where('id', $id)
            ->update(['status' => User::STATUS_ACTIVE]);
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

    /**
     * Gửi email cho people theo batch (10 người một lần), chỉ gửi cho status = 1
     *
     * @return array
     */
    
    public function sendBatchEmailsToPeople()
    {
        $query = User::query()->where('status', User::STATUS_ACTIVE);
        $totalPeople = $query->count();
        if ($totalPeople === 0) {
            return CommandResponse::error('Không có người nào có status = 1 để gửi email');
        }

        $batchCount = 0;
        $query->latest('id')
            ->select('id', 'email')
            ->chunk(10, function($users) use (&$batchCount) { 
                $batchCount++;
                $userIds = $users->pluck('id')->all();
                SendBatchEmailJob::dispatch($batchCount, $userIds);
            });

        return CommandResponse::success("Đã lên lịch gửi email cho {$totalPeople} người (status = 1) trong {$batchCount} batch");
    }
    
}
