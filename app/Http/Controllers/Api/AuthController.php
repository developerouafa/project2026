<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('apitoken')->plainTextToken;

        return response()->json([
            'user' => new \App\Http\Resources\UserResource($user),
            'token' => $token,
        ], 201);
    }

    // التسجيل (مكرر - يفضل حذفه أو دمجه، سأبقيه كما هو مع تحديث الاستجابة)
    public function registertwo(Request $request)
    {
        $user = User::create([
            'name' => 'ououou',
            'email' => 'ououou' . rand(1000, 9999) . '@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $token = $user->createToken('apitoken')->plainTextToken;

        return response()->json([
            'user' => new \App\Http\Resources\UserResource($user),
            'token' => $token,
        ]);
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        // return $request;
        // tarekaeae@gmail.com password123
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => '❌ بيانات غير صحيحة'], 401);
        }

        $token = $user->createToken('apitoken')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'user' => new \App\Http\Resources\UserResource($user),
            'token' => $token,
        ]);
    }

    // الخروج
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => '✅ تم تسجيل الخروج']);
    }

    // جلب بيانات المستخدم الحالي
    public function user(Request $request)
    {
        return new \App\Http\Resources\UserResource($request->user());
    }
}
