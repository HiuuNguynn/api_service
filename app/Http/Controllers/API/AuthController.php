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
        $result = $this->authService->loginUser($request->validated());
        return ApiResponse::success([
            'user' => $result['user'],
            'token' => $result['token'],
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Đăng xuất thành công']);
        }
        return response()->json(['message' => 'Không tìm thấy phiên đăng nhập'], 401);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $result = $this->authService->registerUserAndPerson($validated);
        return ApiResponse::success([
            'user' => $result['user'],
            'person' => $result['person'],
        ], 'Đăng ký thành công', 201);
    }

    public function changePassword(ChangePassWord $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        $this->authService->changePassword($user, $validated);
        return ApiResponse::success('Đổi mật khẩu thành công');
    }

    public function resetPassword(ResetPassWord $request)
    {
        $validated = $request->validated();
        $status = $this->authService->resetPassword($validated);
        return $status === Password::PASSWORD_RESET 
        ? ApiResponse::success('Đặt lại mật khẩu thành công') 
        : ApiResponse::error(__($status), 400);
    }
    
    public function forgotPassword(EmailRequest $request)
    {
        $validated = $request->validated();
        $status = $this->authService->sendResetPasswordMail($validated);
        return $status === Password::RESET_LINK_SENT 
        ? ApiResponse::success('Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư!') 
        : ApiResponse::error('Không thể gửi email đặt lại mật khẩu.', 400);
    }

    public function deleteAccount($id)
    {
        $this->authService->deleteAccount($id);
        return ApiResponse::success();
    }
} 