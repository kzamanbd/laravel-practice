<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['currentUser','logout']);
    }

    //current user
    public function currentUser(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user],200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request) : JsonResponse
    {
        if($request->strategy == "facebook"){
            return $this->loginWithFacebook($request);
        }
        elseif($request->strategy == "github"){
            return $this->loginWithGithub($request);
        }
        elseif($request->strategy == "google"){
            return $this->loginWithGoogle($request);
        }
        else{
            $this->validate($request,[
                'email' => 'required',
                'password' => 'required|min:6',
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if ($user && Hash::check($request->password, $user->password)) {
    
                $token = $user->createToken($request->email);
    
                return response()->json([
                    'user' => $user,
                    'message' => 'Login Successful',
                    'response_code' => 200,
                    'token' => $token->plainTextToken
                ]);
            }
            else{
                // throw ValidationException::withMessages([
                //     'email' => ['The provided credentials are incorrect.'],
                // ]);
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }
        

    }


    private function loginWithGithub($userData){
        $user = User::where("email", $userData->email)->first();
        $regularUser = User::where("email", $userData->email)->whereNull("github_id")->first();

        if($user == null && $regularUser != null){ //Checking for regular existing member with only email
            $regularUser->github_id = $userData->id;
            $regularUser->save();
            $user = $regularUser;
        }
        if($user == null){
            $user = User::create([
                "name"              => $userData->name,
                "email"             => $userData->login.'@github.com',
                'username'          => $userData->login,
                "github_id"         => $userData->id,
                "email_verified_at" => now(),
            ]);
        }
        $token = $user->createToken($user->email);
    
        return response()->json(['token' => $token->plainTextToken], 201);
    }

    private function loginWithFacebook($userData){
        $user = User::where("email", $userData->email)->first();
        $fbUser = User::where("facebook_id", $userData->id)->first(); //Facebook User Without Email address
        $regularUser = User::where("email", $userData->email)->whereNull("facebook_id")->first();
        

        if($user == null && $fbUser == null && $regularUser != null){ //Checking for regular existing member with only email
            $regularUser->facebook_id = $userData->id;
            $regularUser->save();
            $user = $regularUser;
        }
        elseif($fbUser != null){
            $user = $fbUser;
        }

        if($user == null){
            //Uploading Photo From Facebook URL
            // $contents = file_get_contents($userData->picture["data"]["url"]);
            // $name = "images/member" . $this->memberId() . "_" . uniqid() . ".jpg";
            // Storage::disk("public")->put($name, $contents);

            $user = User::create([
                "name"              => $userData->name,
                "email"             => $userData->email,
                'username'          => explode('@', $userData->email)[0],
                "facebook_id"       => $userData->id,
                "email_verified_at" => now(),
            ]);
        }
        $token = $user->createToken($userData->email);
    
        return response()->json(['token' => $token->plainTextToken], 201);
    }

    private function loginWithGoogle($userData){
        $user = User::where("email", $userData->email)->where("google_id",$userData->sub)->first();
        $regularUser = User::where("email", $userData->email)->whereNull("google_id")->first();

        if($user == null && $regularUser != null){ //Checking for regular existing member with only email
            $regularUser->google_id = $userData->sub;
            $regularUser->save();
            $user = $regularUser;
        }
        if($user == null){
            $user = User::create([
                "name"              => $userData->name,
                "email"             => $userData->email,
                'username'          => explode('@', $userData->email)[0],
                "google_id"         => $userData->sub,
                "email_verified_at" => now(),
            ]);
        }
        $token = $user->createToken($user->email);
    
        return response()->json(['token' => $token->plainTextToken], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => explode('@', $request->email)[0],
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            //create token
            $token = $user->createToken($request->email);

            return response()->json([
				'user' => $user,
                'message' => 'Registration Successful',
                'response_code' => 200,
                'token' => $token->plainTextToken
			]);
        }
        else{
            //error message
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    protected function credentials($request)
    {
        return $request->only('email', 'password');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' =>'You are Successfully Logged out'], 200);
    }
}
