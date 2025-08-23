<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ship_address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AccountController extends Controller
{
    private function userData(User $user)
    {
        return [
            'id'        => $user->id,
            'email'     => $user->email,
            'username'  => $user->username,
            'fullname'  => $user->fullname,
            'birth_day' => $user->birth_day,
            'phone'     => $user->phone,
            'address'   => $user->address,
            'role'      => $user->role,
            'is_active' => $user->is_active,
            'avatar'    => $user->avatar ? asset('storage/' . ltrim($user->avatar, '/')) : null,
        ];
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,4}$/', 'unique:users,email'],
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ]);

        try {
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role ?? 0,
            ]);

            return response()->json(['status' => true, 'message' => 'Đăng kí thành công', 'data' => ['email' => $user->email]]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);

            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Sai tài khoản hoặc mật khẩu'], 401);
            }

            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return response()->json(['error' => 'Tài khoản đã bị khóa'], 403);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Đăng nhập thành công',
                'data'    => ['user' => $this->userData($user), 'token' => $user->createToken('API Token')->plainTextToken]
            ]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with('shipAddresses')->find($id);
            if (!$user) return response()->json(['message' => 'User not found'], 404);

            $token = substr($user->createToken('API Token')->plainTextToken, 3);
            $user->avatar = $user->avatar ? asset("storage/$user->avatar") : null;

            $filePath = storage_path("app/user_{$id}.txt");
            $data = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
            return response()->json(array_merge($data, ['token' => $token, 'user' => $user]));
        } catch (Throwable $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 404);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens->each->delete();
            return response()->json(['status' => true, 'message' => 'Đăng xuất thành công']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Có lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function address()
    {
        $ship = Ship_address::where('user_id', auth()->id())->orderByDesc('is_default')->orderByDesc('created_at')->first();
        return $ship
            ? response()->json(["status" => "success", "data" => $ship])
            : response()->json(["status" => "error", "message" => "No shipping address found"], 404);
    }

    public function checkAuth(Request $request)
    {
        $token = $request->cookie('token') ? substr($request->cookie('token'), 4) : null;
        if (!$token && $request->header('Authorization') && preg_match('/Bearer\s(\S+)/', $request->header('Authorization'), $m)) {
            $token = $m[1];
        }

        if (!$token) return response()->json(['authenticated' => false, 'message' => 'Token not provided.'], 401);

        $record = PersonalAccessToken::where('token', hash('sha256', $token))->first();
        if ($record) {
            $user = $record->tokenable;
            return response()->json(['authenticated' => true, 'user' => $user, 'role' => $user->role]);
        }

        return response()->json(['authenticated' => false, 'message' => 'Invalid token.'], 401);
    }
}
