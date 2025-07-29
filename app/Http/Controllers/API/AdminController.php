<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use App\Helpers\ApiResponse;
use App\Http\Requests\API\ImportFile;
use App\Http\Requests\API\SetRole;
use App\Http\Requests\API\ChangeDepartment;
use Exception;
class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function setRole(SetRole $request)
    {
        $validated = $request->validated();
        $this->adminService->setRole($validated);
        return ApiResponse::success('User set to successfully');
    }

    public function setUser($id)
    {
        $this->adminService->setUser($id);
        return ApiResponse::success('User set to user successfully');
    }

    public function exportUsers()
    {
       return $this->adminService->exportUsers();
    }

    public function importUsers(ImportFile $request)
    {
        $file = $request->file('file');
        return $this->adminService->importUsers($file);
    }

    public function usersDeleted()
    {
        $users = $this->adminService->usersDeleted();
        return ApiResponse::success('Users fetched successfully', 200, ['data' => $users]);
    }

    public function sendBatchEmailsToPeople()
    {
        $this->adminService->sendBatchEmailsToPeople();
        return ApiResponse::success('Email sent successfully');
    }

    public function changeDepartment(ChangeDepartment $request)
    {
        $validated = $request->validated();
        try {
            $this->adminService->changeDepartment($validated);
            return ApiResponse::success('Department changed successfully');
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }
}   