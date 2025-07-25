<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\ChangePassWord;
use App\Http\Requests\API\ResetPassWord;
use App\Service\AuthService;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\API\EmailRequest;
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $this->authService->loginUser($request->validated());
        return ApiResponse::success('Login successful', 200);
    }

    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout successful']);
        }
        return response()->json(['message' => 'No active session found'], 401);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $this->authService->registerUserAndPerson($validated);
        return ApiResponse::success('Registration successful', 201);
    }

    public function changePassword(ChangePassWord $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        $this->authService->changePassword($user, $validated);
        return ApiResponse::success('Password changed successfully');
    }

    public function resetPassword(ResetPassWord $request)
    {
        $validated = $request->validated();
        $status = $this->authService->resetPassword($validated);
        return $status === Password::PASSWORD_RESET 
        ? ApiResponse::success('Password reset successfully') 
        : ApiResponse::error(__($status), 400);
    }
    
    public function forgotPassword(EmailRequest $request)
    {
        $validated = $request->validated();
        $status = $this->authService->sendResetPasswordMail($validated);
        return $status === Password::RESET_LINK_SENT 
        ? ApiResponse::success('Password reset email sent. Please check your inbox!') 
        : ApiResponse::error('Unable to send password reset email.', 400);
    }

    public function deleteAccount($id)
    {
        $authUser = auth()->user();
        $emailAdmin = $authUser->email;
        $this->authService->deleteAccount($id, $emailAdmin);
        return ApiResponse::success('Account deleted successfully');
    }

    public function restoreAccount($id)
    {
        $this->authService->restoreAccount($id);
        return ApiResponse::success('Account restored successfully');
    }
} 