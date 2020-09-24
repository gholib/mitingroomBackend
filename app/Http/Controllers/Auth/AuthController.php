<?php

namespace App\Http\Controllers\Auth;

use App\Modules\Auth\Models\User;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Requests\UpdateAccountDataRequest;
use App\Modules\Auth\UserService;
use App\Modules\Users\Requests\ResetPasswordRequest;
use App\Modules\Users\Requests\VerifyRequest;
use App\Modules\Users\UseCases\ForgetPassword;
use App\Modules\Users\UseCases\VerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\{JWTException};

class AuthController extends Controller
{
    protected $auth;
    /**
     * @var ForgetPassword
     */
    private $forgotPassword;

    public function __construct(JWTAuth $auth, ForgetPassword $forgotPassword)
    {
        $this->auth = $auth;
        $this->forgotPassword = $forgotPassword;
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!$token = $this->auth->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'errors' => [
                        'root' => 'Could not sign you in with those details.'
                    ]
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'errors' => [
                    'root' => 'Failed.'
                ]
            ], $e->getStatusCode());
        }

        return response()->json([
            'data' => $request->user(),
            'meta' => [
                'token' => $token
            ]
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $this->auth->attempt($request->only('email', 'password'));

        VerifyEmail::sendVerificationLink($request->email);

        return response()->json([
            'data' => $user,
            'meta' => [
                'token' => $token,
                'message' => "Для активации аккаунта мы в вашу почту скинули ссылку,
                 пожалуйста перейдите по ссылке и активируйте аккаунт!"
            ]
        ], 200);
    }

    public function logout()
    {
        $this->auth->invalidate($this->auth->getToken());

        return response(null, 200);
    }

    public function user(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }

    public function forgotUserPassword(Request $request) :JsonResponse
    {
        $this->validate($request, [
            'email' => [
                'required',
                'email',
                Rule::exists('users')->where(function ($query) use ($request) {
                    $query->where('email', $request->email);
                }),
            ],
        ],
        ['email.exists' => 'Пользователь не найден :(']);

        return response()->json(['forgetPassword' => $this->forgotPassword->forgotPassword($request->email)]);
    }

    public function resetUserPassword(ResetPasswordRequest $request) :JsonResponse
    {
        $requestOnly = $request->only(['email', 'password', 'token']);

        return response()->json(['resetPassword' => $this->forgotPassword->resetPassword($requestOnly)]);
    }

    public function verifyUserEmail($email, $verifyToken)
    {
        $user = User::where('email', $email)->where('verify_token', $verifyToken)->first();
        if (!$user) {
            return response()->json("Неправильные данные!", 404);
        }
        VerifyEmail::verifyAccount($user);

        return response()->json("Успешная активация!", 200);
    }

    public function sendVerifyLink()
    {
        $user = Auth::user();
        VerifyEmail::sendVerificationLink($user->email);

        return response()->json("Мы отправили ссылку активации в вашу почту!", 200);
    }
}
