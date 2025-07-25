<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\StorePersonRequest;
use App\Service\UserService;
use App\Helpers\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function update(StorePersonRequest $request, $id) 
    {
        $validated = $request->validated();
        $curId = auth()->user()->id;
        if($curId != $id) {
            throw new AuthorizationException();
        }
        $this->userService->updateUser($id, $validated);
        return ApiResponse::success('Person updated successfully');
    }


    public function getAllPeople()
    {
        $this->userService->getAllPeople($request->per_page ?? 10);
        return ApiResponse::success('All people fetched successfully');
    }

}
