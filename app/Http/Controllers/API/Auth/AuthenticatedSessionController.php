<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        if ($request->input('strategy') == 'facebook') {
            return $this->loginWithFacebook($request);
        } elseif ($request->input('strategy') == 'github') {
            return $this->loginWithGithub($request);
        } elseif ($request->input('strategy') == 'google') {
            return $this->loginWithGoogle($request);
        } else {

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
                    'response_code' => 200,
                    'message' => 'Login Successful',
                    'token' => $token->plainTextToken,
                    'user' => $user,
                ]);
            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }
    }

    private function loginWithGithub($userData)
    {
        $user = User::query()->where('email', $userData->email)->first();
        $regularUser = User::query()->where('email', $userData->email)->whereNull('github_id')->first();

        if ($user == null && $regularUser != null) { //Checking for regular existing member with only email
            $regularUser->github_id = $userData->id;
            $regularUser->save();
            $user = $regularUser;
        }
        if ($user == null) {
            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->login . '@github.com',
                'username' => $userData->login,
                'github_id' => $userData->id,
                'email_verified_at' => now(),
            ]);
        }
        $token = $user->createToken($user->email);

        return response()->json(['token' => $token->plainTextToken], 201);
    }

    private function loginWithFacebook($userData)
    {
        $user = User::query()->where('email', $userData->email)->first();
        $fbUser = User::query()->where('facebook_id', $userData->id)->first(); //Facebook User Without Email address
        $regularUser = User::query()->where('email', $userData->email)->whereNull('facebook_id')->first();

        if ($user == null && $fbUser == null && $regularUser != null) { //Checking for regular existing member with only email
            $regularUser->facebook_id = $userData->id;
            $regularUser->save();
            $user = $regularUser;
        } elseif ($fbUser != null) {
            $user = $fbUser;
        }

        if ($user == null) {
            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'username' => explode('@', $userData->email)[0],
                'facebook_id' => $userData->id,
                'email_verified_at' => now(),
            ]);
        }
        $token = $user->createToken($userData->email);

        return response()->json(['token' => $token->plainTextToken], 201);
    }

    private function loginWithGoogle($userData)
    {
        $user = User::query()->where('email', $userData->email)->where('google_id', $userData->sub)->first();
        $regularUser = User::query()->where('email', $userData->email)->whereNull('google_id')->first();

        if ($user == null && $regularUser != null) { //Checking for regular existing member with only email
            $regularUser->google_id = $userData->sub;
            $regularUser->save();
            $user = $regularUser;
        }
        if ($user == null) {
            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'username' => explode('@', $userData->email)[0],
                'google_id' => $userData->sub,
                'email_verified_at' => now(),
            ]);
        }
        $token = $user->createToken($user->email);

        return response()->json(['token' => $token->plainTextToken], 201);
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
                'response_code' => 200,
                'message' => 'Login Successful',
                'token' => $token->plainTextToken,
                'user' => $user,
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
