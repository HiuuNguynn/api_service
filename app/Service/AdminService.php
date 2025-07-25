<?php

namespace App\Service;

use App\Models\User;
use App\Helpers\ApiResponse;
use App\Http\Requests\API\ImportFile;
use App\Http\Requests\API\ValidationFailures;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Jobs\SendBatchEmailJob;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Helpers\CommandResponse;

class AdminService
{
    
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

    public function setAdmin($id)
    {
        return User::find($id)->update(['role' => User::ROLE_ADMIN]);
    }

    public function setUser($id)
    {
        return User::find($id)->update(['role'=> User::ROLE_USER]);
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function usersDeleted()
    {
        return User::onlyTrashed()->get();
    }

    public function importUsers($file)
    {
        DB::beginTransaction();

        try {
            Excel::import(new UsersImport, $file);
            DB::commit();
            return ApiResponse::success('Import users successfully');
        } catch (ValidationException $e) {
            DB::rollBack();
            $errorDetails = ValidationFailures::format($e->failures());
            return ApiResponse::error('Import failed', 422, ['details' => $errorDetails]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Import users failed: ' . $e->getMessage());
            return ApiResponse::error('Import failed during import', 500, ['details' => [$e->getMessage()]]);
        }
    }
}