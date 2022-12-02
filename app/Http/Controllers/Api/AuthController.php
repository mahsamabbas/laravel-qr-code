<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\UserValidation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @param UserValidation $userValidation
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request, UserValidation $userValidation)
    {
        $userValidation = $userValidation->validateUserForRegister($request);

        if ($userValidation->fails()){
            return response()->json([
                'error' => $userValidation->getMessageBag(),
                'status' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_OK);

        }
        if (auth()->attempt($request->all())) {
            return response([
                'user' => auth()->user(),
                'access_token' => auth()->user()->createToken('authToken')->accessToken,
                'status' => Response::HTTP_OK
                ]);
        }

        return response([
            'message' => 'This User does not exist',
            'status' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param UserValidation $userValidation
     * @return JsonResponse
     */
    public function register(Request $request, UserValidation $userValidation)
    {
        $userValidation = $userValidation->validateUserForLogin($request);

        if ($userValidation->fails()){
            return response()->json([
                'error' => $userValidation->getMessageBag(),
                'status' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_OK);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

     /**
      * Get the authenticated User
      *
      * @param Request $request
      * @return JsonResponse [json] user object
      */
     public function client(Request $request)
     {
         $client = DB::table('oauth_clients')->first();

         if ($client) {
             return response()->json([
                 'client-secret' => $client->secret,
                 'status' => Response::HTTP_OK
             ], Response::HTTP_OK);
         } else {
             return response()->json([
                 'message' =>  'No client registered yet',
                 'status' => Response::HTTP_BAD_REQUEST
             ], Response::HTTP_OK);
         }
     }
}




























































