<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            $error = Json_decode($validator->messages()->toJson());
            return response()->json([
                'error' => [
                    "message" => $error,
                    "type" => ["ValidationException"]
                ],
            ], 302);
        }
        else {

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {

                return response()->json([
                    'error' => [
                        "message" => ["Email ou mot de passe incorrect !"],
                    ],
                ], 400);
            }

            $token = $user->createToken($request->email)->plainTextToken;

            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ], 200);
        }
    }
}
