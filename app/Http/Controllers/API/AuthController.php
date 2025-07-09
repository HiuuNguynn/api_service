<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\ChangePassWord;
use App\Http\Requests\API\ResetPassWord;
use App\Service\AuthService;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
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
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $this->authService->createAccessToken($user);
            return ApiResponse::success([
                'user' => $user,
                'token' => $token,
            ]);
        }

      return ApiResponse::error('Sai thông tin đăng nhập', 401);
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
        if (!Hash::check($validated['old_password'], $user->password)) {
            return response()->json(['message' => 'Mật khẩu cũ không đúng'], 400);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json(['message' => 'Đổi mật khẩu thành công']);
    }

    public function resetPassword(ResetPassWord $request)
    {
        $validated = $request->validated();
        $status = $this->authService->resetPassword($validated);
        if ($status === Password::PASSWORD_RESET) {
            return ApiResponse::success('Đặt lại mật khẩu thành công');
        } else {
            return ApiResponse::error(__($status), 400);
        }
    }
    
    public function forgotPassword(EmailRequest $request)
    {
        $validated = $request->validated();
        $status = $this->authService->sendResetPasswordMail($validated);

        if ($status === Password::RESET_LINK_SENT) {
            return ApiResponse::success('Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư!');
        } else {
            return ApiResponse::error('Không thể gửi email đặt lại mật khẩu.', 400);
        }
    }

} 