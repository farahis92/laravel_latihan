<?php

use App\Http\Controllers\NewsController;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data', [NewsController::class, 'index']);

Route::post('/test', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'phone' => 'required',
    ]);

    if ($validator->fails()) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ], 422));
    }

    $contact = Contact::create($request->only('name', 'phone'));
    return response()->json($contact, 200);
});

Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ], 422));
    }

    $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ], 200);
});

Route::post('/login', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|max:255',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ], 422));
    }

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }

    $user = User::where('email', $request['email'])->firstOrFail();

    $user->tokens()->delete();
    // $token = $user->createToken('auth_token')->plainTextToken;


    // return response()->json([
    //     'access_token' => $token,
    //     'token_type' => 'Bearer',
    // ]);
});
