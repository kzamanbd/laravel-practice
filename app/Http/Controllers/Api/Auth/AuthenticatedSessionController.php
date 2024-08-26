<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @tags Auth
 */
class AuthenticatedSessionController extends Controller
{

    /**
     * Current User
     * @operationId current-user
     */
    public function currentUser(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    /**
     * Login
     * @operationId login
     */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            /**
             * @var string
             * @example kzamanbn@gmail.com
             */
            'email' => 'required',
            /**
             * @var string
             * @example password
             */
            'password' => 'required|min:6',
        ]);

        $user = User::query()->where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {

            $token = $user->createToken($request->input('email'));

            return response()->json([
                'success' => true,
                'message' => 'Login Successful',
                'data' => [
                    'user' => $user,
                    'token' => $token->plainTextToken,
                ],
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid Credentials Provided',
                'success' => false,
                'data' => null,
            ], 401);
        }
    }

    /**
     * Register
     * @operationId register
     */
    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => explode('@', $request->input('email'))[0],
            'password' => Hash::make($request->input('password')),
        ]);

        if ($user) {
            $token = $user->createToken($request->input('email'));

            return response()->json([
                'message' => 'User Registered Successfully',
                'success' => true,
                'data' => [
                    'user' => $user,
                    'token' => $token->plainTextToken,
                ],
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    protected function credentials($request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Logout
     * @operationId logout
     */

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'You are Successfully Logged out'], 200);
    }
}
