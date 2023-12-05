<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\WhatsAppNotificationController;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ! Login
    public function login(Request $request)
    {
        try {
            // * Credentials (username, email, phone)
            $credentials = $request->input('credentials');
            $input = filter_var($credentials, FILTER_VALIDATE_EMAIL)
                ? 'email'
                : (ctype_digit($credentials) ? 'phone_number' : 'username');

            // * Validate Request
            $validator = Validator::make($request->all(), [
                'credentials' => 'required',
                'password' => 'required'
            ]);

            // * Check Validation
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            // * Check if User exists
            $user = User::where($input, $credentials)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials do not match our records.'
                ], 404);
            }

            // * Check password match
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password does not match.'
                ], 401);
            }

            // * Update Last Login using Carbon
            $user->last_login = now();
            $user->save();

            // * Create Token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged in',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // ! Register
    public function register(Request $request)
    {
        try {
            // * Validate Request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:50|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:20|unique:users',
                'address' => 'nullable|string',
                'password' => 'required|string|min:8|confirmed',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            // * Check Validation
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 422);
            }

            // * Image Path Default
            $imagePath = null;
            // * Check if profile_picture is not null
            if ($request->hasFile('profile_picture')) {
                // * Generate a random string of 10 characters
                $randomString = Str::random(10);
                // * Get Current Date
                $currentDate = date('d_m_Y');
                // * Generate File Name
                $fileName = $currentDate . '_' . $randomString . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                // * Save File in Public Folder
                $request->file('profile_picture')->storeAs('profile_pictures', $fileName, 'public');
                // * Set Image Path
                $imagePath = 'profile_pictures/' . $fileName;
            } else {
                // * Set Image Path
                $imagePath = 'profile_pictures/default.png';
            }

            // * Check if Phone Number start with '0' or '8'
            $phone_number = $request->phone_number;
            // * Remove non-numeric characters
            $phone_number = preg_replace('/[^0-9]/', '', $phone_number);
            if (substr($phone_number, 0, 1) === '0' || substr($phone_number, 0, 1) === '8') {
                // * Replace leading '0' or '8' with '62'
                $phone_number = '62' . substr($phone_number, 1);
            } else {
                $phone_number = null;
            }

            // * Create User
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => strtolower($request->email),
                'phone_number' => $phone_number,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'profile_picture' => $imagePath
            ]);

            // * Create Token
            $token = $user->createToken('myToken')->plainTextToken;

            // * Return Response
            return response()->json([
                'success' => true,
                'message' => 'Successfully registered',
                'token' => $token,
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // ! Logout
    public function logout(Request $request)
    {
        try {
            // * Revoke Token
            $request->user()->currentAccessToken()->delete();

            // * Return Response
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // ! Get User
    public function getUser(Request $request)
    {
        try {
            // * Return Response
            return response()->json([
                'success' => true,
                'message' => 'Successfully get user',
                'user' => $request->user()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
